# Harvest API PHP via forms
This package provides a comprehensive implementation of Harvest API documentation in PHP, enabling the user to connect to Harvest API via CURL and set data like a standalone website application with forms.

![Screen 1](https://github.com/mateusz-peczkowski/harvest-php-form-integration/blob/master/screens/1.png?raw=true)

## Actions
- Duplicate entries from one day to many days
- Remove entries for a specific day
- Set hours for entries for a specific day based on another day

## Requirements
- PHP 8.1 or higher
- Composer
- Harvest API token (token can be acquired through: https://id.getharvest.com/developers)

## Installation
1. Clone the repository and install dependencies
```bash
composer install
```
2. Attach domain to public directory
3. Configure `.env` file based on `.env.example`
