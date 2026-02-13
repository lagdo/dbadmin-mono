A database admin dashboard based on Jaxon and Adminer
=====================================================

Jaxon DbAdmin is a complete rewrite of [Adminer](https://github.com/vrana/adminer), the popular database admin dashboard.

It inserts a database admin dashboard into an existing PHP application.
Thanks to the [Jaxon library](https://www.jaxon-php.org), it installs and runs in a page of the application.
All its operations are performed with Ajax requests.

## Features and current status

This application and the related packages are still being actively developed, and the provided features are still basic and need improvements.

The following features are currently available:
- Browse servers and databases in multiple tabs.
- Open the query editor in multiple tabs, with query text retention.
- Save and show the query history.
- Save queries in user favorites.
- Read database credentials with an extensible config reader.
- Read database credentials from an [Infisical](https://infisical.com/) server.
- Show tables and views details.
- Query a table.
- Query a view.
- Execute queries in the query editor.
- Use a better editor for SQL queries.
- Import or export data.
- Insert, modify or delete data in a table.
- Create or drop a database.
- Create or alter a table or view.
- Drop a table or view.

The following features are not yet implemented, and planned for future releases:
- Save the current tabs in user preferences.
- Navigate through related tables.
- Code completion for table and field names in the SQL editor.
- An advanced GUI-based query builder.
- Automated tests.

Documentation and howtos
------------------------

The [documentation](https://github.com/lagdo/jaxon-dbadmin) explains how to install and configure the package.
This blog post on the `Jaxon` website explains how to install `Jaxon DbAdmin` on [Backpack](https://backpackforlaravel.com), a Laravel-based admin panel: https://www.jaxon-php.org/blog/2025/07/install-jaxon-dbadmin-on-backpack.html.

Contribute
----------

- Issue Tracker: https://github.com/lagdo/dbadmin-mono/issues
- Source Code: https://github.com/lagdo/dbadmin-mono

License
-------

The project is licensed under the Apache license.
