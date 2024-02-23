# Molveno Restaurant App

## Quick setup

```bash
    git clone git@github.com:codivations/molveno-restaurant.git

    cd molveno-restaurant

    cp .env.example .env
    # Important: check the .env if the database settings are correct for your system
    # and change if necessary

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

If you want to run prettier manually, you can run the following command:

```bash
    npm run lint-prettier
```

If prettier finds any problems, you can use the following command to fix them:

```bash
    npm run fix-prettier
```

## Git

### Features

Features are implemented using a few steps:

1. Pull the latest version of `main`.
2. Create a new branch with the format `patch-{name}-{feature}`.
3. Write your changes with multiple commits.
4. Try to merge the `main` branch.
5. Create and merge a Pull Request on github.

Example:

```bash
    # Pull the latest version of main
    git pull

    # Create a new branch
    git switch -C patch-etienne-add-recipe-model

    # Make changes
    git commit -m "Write recipe model"
    git commit -m "Write relations for recipe model"
    git commit -m "Write unit tests for recipe model"
    git commit -m "Document recipe model"

    # Merge main
    git pull origin main
    git merge main -m "Merge main into feature"

    # Create a pull request on github
```

There are a few important rules:

- Feature branches are supposed to be short. It is better to merge too often as opposed to merging not often enough
- Each feature must only do one thing. Do not fix an unrelated piece of code in the same feature branch where you implement a new feature
- Always use clear and relevant titles in the pull requests. These will be visible in the git history.

### Commits

- The first line of each commit must not exceed 50 characters.
- The first word of the commit is capitalized.
- The first word of the commit is always a verb describing what has been done. Examples:
  - Write
  - Fix
  - Change
  - Refactor
  - Document
- The first word is always in present tense
  - correct: Write
  - incorrect: Written
- If more lines are added 1 white space must come after the first line.
- The first line of the commit message does not use any punctuation (.,).
