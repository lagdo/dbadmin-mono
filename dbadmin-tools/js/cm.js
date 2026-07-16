import { EditorView, basicSetup } from "codemirror";
import { EditorState } from '@codemirror/state';
import { sql, MySQL, PostgreSQL, SQLite, StandardSQL } from '@codemirror/lang-sql';

(function(self, types) {
    /**
     * @param {string} containerId
     * @param {bool} readOnly
     * @param {string} driver
     * @param {object} schema
     *
     * @returns {object}
     */
    self.create = function(containerId, readOnly, driver, { tables } = {}) {
        const container = document.getElementById(containerId);
        if (!container) {
            return null;
        }

        // Save the query text and clear the editor container.
        const queryText = container.textContent;
        container.innerHTML = '';

        const schema = !types.isArray(tables) || tables.length === 0 ? null :
            tables.reduce((schema, { name: tableName, columns }) => {
                schema[tableName] = columns.map(({ name: columnName }) => columnName);
                return schema;
            }, {});
        return {
            driver,
            instance: self.lib.editor(container, queryText, readOnly, driver, schema),
        };
    };

    /**
     * @param {object} editor
     * @param {string} query
     *
     * @returns {void}
     */
    self.setQuery = ({ instance } = {}, query) => instance?.dispatch({
        changes: { from: 0, to: instance.state.doc.length, insert: query },
    });

    /**
     * @param {object} editor
     * @param {bool} takeSelectedText
     *
     * @returns {string}
     */
    self.getQuery = ({ instance } = {}, takeSelectedText = false) => {
        if (!instance) {
            return '';
        }

        const { state: editorState } = instance;
        const { doc: queryText } = editorState;
        if (!takeSelectedText) {
            return queryText.toString() ?? '';
        }

        // Try to get the selected text first.
        const { selection: { main: { from, to } } } = editorState;
        const selectedText = editorState.sliceDoc(from, to);
        return selectedText ? selectedText : (queryText.toString() ?? '');
    };

    /**
     * Set the SQL query value and reset the undo history.
     *
     * @param {object} editor
     * @param {string} query
     *
     * @returns {void}
     */
    self.resetQuery = (editor, query) => self.setQuery(editor, query);
    // self.resetQuery = ({ instance } = {}, query) =>
    //     instance?.setState(EditorState.create({doc: query }));

    /**
     * Refresh the editor by resetting the SQL query to its current value.
     * (Nothing to do here, since the CodeMirror editor does not need to be refreshed.)
     *
     * @param {object} editor
     *
     * @returns {void}
     */
    self.refreshQuery = (editor) => false, // self.setQuery(editor, self.getQuery(editor, false));

    /**
     * @param {object} editor
     * @param {string} query
     *
     * @returns {void}
     */
    self.insertQuery = ({ instance } = {}, query) => {
        if (!instance) {
            return;
        }

        const { state: { selection: { main: { from, to } } } } = instance;
        instance.dispatch({ changes: { from, to, insert: query } });
    };

    const modes = {
        mysql: MySQL,
        pgsql: PostgreSQL,
        sqlite: SQLite,
        default: StandardSQL,
    };

    const extensions = [
        basicSetup,
        EditorState.allowMultipleSelections.of(false),
        EditorView.lineWrapping,
        EditorView.theme({
            "&": {
                height: "100%",
                fontSize: "13px"
            },
            ".cm-content": {
                fontFamily: "'JetBrains Mono', 'Fira Code', 'Monaco', 'Menlo', monospace",
                padding: "5px"
            },
            ".cm-gutters": {
                backgroundColor: "#f8f9fa",
                borderRight: "1px solid #e9ecef"
            },
        }),
    ];

    /**
     * @var {object} lib Functions from the CodeMirror modules.
     */
    self.lib = {};

    jaxon.dom.ready(() => {
        /**
         * Create a CodeMirror editor instance.
         *
         * @param {HTMLElement} parent The parent element to attach the editor to.
         * @param {string} queryText The initial query text to display in the editor.
         * @param {boolean} readOnly Whether the editor should be read-only.
         * @param {string} driver The database driver (e.g., "mysql", "pgsql", "sqlite").
         * @param {object|null} schema The database schema information, if available.
         *
         * @returns {EditorView} The created CodeMirror editor instance.
         */
        self.lib.editor = (parent, queryText, readOnly, driver, schema) => {
            const sqlOptions = {
                dialect: modes[driver] ?? modes.default,
                upperCaseKeywords: true,
                ...(!schema ? {} : { schema }),
            };
            const state = EditorState.create({
                doc: queryText,
                extensions: [
                    ...extensions,
                    EditorState.readOnly.of(readOnly),
                    sql(sqlOptions),
                ],
            });

            return new EditorView({ state, parent });
        };
    });
})(jaxon.dbadmin.editor, jaxon.utils.types);
