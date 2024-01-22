# Molveno Restaurant App

## Quick setup

```bash
    cp .env.example .env
    # change values in .env if needed

    composer install
    npm install

    php artisan key:generate

    php artisan migrate --seed

    php artisan serve
```

## Linting

This project uses prettier to enforce code style.
VsCode has the [prettier extension](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode) which can automatically format the document on save.
It is highly recommended to use this plugin when using vscode.

Included in this repository is a pre-commit hook.
This will automatically run the linter before commiting.
To use the hook run the following command:

```bash
    git config core.hooksPath .githooks
```

## Git

### Features

### Commits
