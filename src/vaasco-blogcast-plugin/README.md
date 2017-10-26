# Vaasco Blogcast Plugin

Vaasco Blogcast is a WordPress plugin which automatically converts categories and blog posts to playlists of audio tracks.

Vaasco Blogcast allows visitors listen to your content while driving, working out and in other handfree environments. It also makes your content accessible to users with visual impairments and motor disabilities.

The plugin is powered by Polly, an Amazon AI service that uses advanced deep learning technologies to synthesize speech that sounds like a human voice. This results in high-quality voice output and word pronunciation.

Simply install the Vaasco Blogcast WordPress plugin and add your Amazon Polly credentials to get started. Easily configure options such as widget theme and categories to use through the WordPress admin panel.

[https://www.vaasco.com/](https://www.vaasco.com/)

This directory contains the PHP code for:

- Vaasco Blogcast plugin installation and activation
- Vaasco Blogcast plugin admin
- Frontend code to embed Vaasco Blogcast widget


## Development

Run the following commands and tasks to load dependencies and build the project:

### Load node dependencies

`npm install`	

Required before running gulp tasks

### Build plugin

`gulp build`

Builds the Vaasco Blogcast plugin by running the following tasks in sequence;

- `npm-update`
- `composer-setup-install`
- `composer-setup-verify`
- `composer-setup-run`
- `composer-setup-unlink`
- `dependencies-install`
- `phplint`

### Update node dependencies

`gulp npm-update`

### Install Composer

`composer-setup-install`

### Verify Composer

`composer-setup-verify`

### Run Composer setup

`composer-setup-run`

### Unlink Composer file

`composer-setup-unlink`

### Install Composer dependencies

`gulp dependencies-install`

### Lint PHP

`gulp phplint `
