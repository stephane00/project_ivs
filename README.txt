Test IVS : 
    Sommaire :
        1. Prérequis for Symfony
        2. Installing & Setting up Server Database (here postgresql)
        3. Api with symfony
        4. Commencer à dev


1. Prérequis for Symfony
    1.1 Installing Technical Requirements
        1.1.1 Dowload php

        1.1.2 Install Composer
            link -> https://getcomposer.org/download/

        1.1.3 (Optionnel) Install Symfony CLI
            link -> https://symfony.com/download
        
    1.2 Creating Symfony Applications
        $ symfony new my_project_directory --version="6.3.*@dev" --webapp

    1.3 Setting up Symfony Framework
        1.3.1 Make Composer install the project's dependencies
            $ cd my-project/
            $ composer install

    1.4 Installing Packages for Symfony
        1.4.1 Installing Packages Twig
            $ composer require symfony/ux-twig-component symfony/twig-bundle

        1.4.2 Installing Packages Doctrine
            $ composer require symfony/orm-pack
                Si on vous demande => Do you want to include Docker configuration from recipes?
                    -> say yes
            
            $ composer require --dev symfony/maker-bundle

        1.4.3 Installing Packages React
            $ composer require symfony/ux-react

                edit webpack.config.js et decommenter
                    .enableReactPreset()

            //installation de paquet pour aider react
            $ yarn add @babel/preset-react --dev --force

                edit assets/app.js et ajouter les lignes suivantes :
                    import { registerReactControllerComponents } from '@symfony/ux-react';

                    // Registers React controller components to allow loading them from Twig
                    //
                    // React controller components are components that are meant to be rendered
                    // from Twig. These component then rely on other components that won't be called
                    // directly from Twig.
                    //
                    // By putting only controller components in `react/controllers`, you ensure that
                    // internal components won't be automatically included in your JS built file if
                    // they are not necessary.
                    registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));

            $ yarn add react-router-dom
            $ yarn add --dev react react-dom prop-types axios
            $ yarn add @babel/plugin-proposal-class-properties @babel/plugin-transform-run

        1.4.4 Installing Module Flex for Symfony
            $ composer require symfony/flex

        1.4.5 Installing Module Routing for Symfony
            $ composer require symfony/routing

2. Installing & Setting up Server Database ( Postgresql )
    2.1 Installation de Postgresql


    2.2 Configuring the Database ( Prérequis -> 1.4.2 Installing Packages Doctrine && 2.1)
        edit the file .env and select the Database connection ( Change !...!  by what you need)
            here -> # DATABASE_URL="postgresql://!db_user!:!db_password!@127.0.0.1:5432/!db_name!?serverVersion=11&charset=utf8"

    2.3 Database with Symfony
        2.3.1 Create the Database with Doctrine
            $ php bin/console doctrine:database:create

        2.3.2 Create an Entity Class
            $ php bin/console make:entity

                data à rentrer pour ce test :
                    1. php bin/console make:entity
                        class name: Organisations
                        new property name: nom
                        field type: string
                        field length: 25
                        field be null: no

                    2. php bin/console make:entity
                        class name: Buildings
                        new property name: nom
                        field type: string
                        field length: 25
                        field be null: no
                        add another property: zipcode
                        field type: integer
                        field be null: no
                        add another property: o_id
                        field type: relation
                        class shoul entity related: Organisations
                        relation type: ManyToOne
                        property allowed to be null: no
                        want to add new property to Organisations: no

                        3. php bin/console make:entity
                        class name: Pieces
                        new property name: nom
                        field type: string
                        field length: 25
                        field be null: no
                        add another property: personnes_presentes
                        field type: integer
                        field be null: no
                        add another property: b_id
                        field type: relation
                        class shoul entity related: Buildings
                        relation type: ManyToOne
                        property allowed to be null: no
                        want to add new property to Organisations: no

                les entities ont étaient créer et ajouter dans le dossier src/Entity
        
        2.3.3 Migrations - Creating the Database Tables
            $ php bin/console make:migration
            $ php bin/console doctrine:migrations:migrate

                A Warning will pop up about the migration, you need to say yes for applicate change to the Database

3. Api with Synfony
    3.1 Create a new Controller
        $ php bin/console make:controller ProductController

            for the test:
                1. php bin/console make:controller OrganisationsController
                2. php bin/console make:controller BuildingsController
                3. php bin/console make:controller PiecesController
    
            the controller have been created and add in src/controller directory
            the package Twig also create some file twig in templates directory

4. Ready to code
    4.1 Launch React
        $ yarn watch

    4.2 Launch Server Synfony
        $ symfony server:start

            Go to http://localhost:8000/ If everything is working, you'll see a welcome page

    4.3 Connexion postgresql
        $ psql -U postgres

    4.4 Launch script sql 
        go to the directory of the file
        start postgresql
        go to the wanted database (\c name_database)
        execut the scpit -> \i name_script

    4.5 Composer install to install dependencies from the project
        $npm i