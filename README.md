# Simple 404 Handling
This extension enables simple *404 Page Not Found* handling, also for multilingual sites.
It does not override but uses the TYPO3 core error handling API.

## Motivation
By default the TYPO3 core enables error handling for pages, even with including other pages, but it doesn't support multilingualism.

## Installation
### Installation using Composer (recommended)
In your TYPO3 site folder run 

`composer require typo3-ter/simple_404_handler`
 
to install this extension.

### Installation from TYPO3 Extension Repository (TER)
Download and install the extension with the extension manager module.

## Usage
1. Create a page you want to use as an error page. You can also translate this page later. *Rember the page ID!*
2. Navigate to the Extension Manager and goto the `simple_404_handler` extension settings.
3. Enter the page ID of your error page in `config.404page` and save the configuration.
4. Test your setup by accessing an invalid page (e.g. `index.php?id=-99`)

## Implementation
Note that according to the TYPO3 Core an exception will be thrown if the error page could not be retrieved by the *Page Not Found* handler.
Make sure you've properly set up the exception handlers (especially for production).
