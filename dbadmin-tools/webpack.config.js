import path from "node:path";
import { fileURLToPath } from "node:url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

export default {
    mode: "production",
    performance: {
        hints: "error",
        maxEntrypointSize: 500000,
        maxAssetSize: 500000,
    },
    entry: {
        cm: "./js/cm.js",
        ace: "./js/ace.js",
        index: "./js/index.js",
    },
    output: {
        filename: "[name].js",
        path: path.resolve(__dirname, "assets/dbadmin/editor"),
    },
};
