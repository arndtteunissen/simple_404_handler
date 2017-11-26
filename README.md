# Simple 404 handler for typo3 CMS
This extension uses TYPO3 core error handling API to handle *404 (Page Not Found)* error pages. it also support multilingual Websites

## Motivation
TYPO3 core comes with simple 404 page handling, but it does not support multilingual 404 pages

## Installation
#### To install using [Composer](https://getcomposer.org/)  (recommended)

run the following command in the root folder of your TYPO3 project

`composer require arndtteunissen/simple_404_handler`


#### To install from TYPO3 Extension Repository (TER)
in TYPO3 extension manager module search for `simple_404_handler` and install it.

## Usage
1. From `Web` > `page` module create the page which you want to use as `404` page and remember the page's ID. You can translate this page later on if you need it.
2. Navigate to the Extension Manager module by clicking on `Admin tools` > `Extensions`  and find  `simple_404_handler` from the list of installed extensions.
3. Click on `Simple 404 handler` to see extension's configuration page.
4. Enter the ID of the page you created in step 1 in `404 Error Page` input field and save the configuration.
5. Test to see whether everything work by opening a page which does not exist  (e.g. `www.example.com/index.php?id=-9908098`)

## Implementation
Note that according to the TYPO3 Core an exception will be thrown if the error page could not be retrieved by the *Page Not Found* handler.
Make sure you've properly set up the exception handlers (especially for production).
