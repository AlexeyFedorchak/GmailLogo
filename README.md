# GmailLogo
Library for dynamically creating user logos on PHP, based on Laravel. This lib may be used with another framework or event without, just change input class type from Laravel Model App\User to another. You event may not use models at all, simpty give the text that should be putted into the image.

How to use:

composer require gmail-logo/generator

Now this version is not properly set for installation, so you should do it yourself. Please set autoload, providers and another things... or create your custom classes in App namespace with code of classes in src folder.

Class GmailLogo is processing generating the image for user
Class GmailTools is building special image you would like to generate. You may simpty use already created funtion createGmailLogo.

so if you have model App\User and this model has at least one attribute where it is possible to save the path to logo (you may set the name of this attribute in class GmailLogo), simpty write:

GmailTools::createGmailLogo($user);

$user - is the variable that contains your user data.