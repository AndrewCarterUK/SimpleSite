# Simple Site

This is a simple PHP website by [Andrew Carter](https://twitter.com/AndrewCarterUK).

It has been designed to try and introduce PHP developers to [composer](https://getcomposer.org),
MVC and object oriented programming.

## Instructions

You will need to install [composer](https://getcomposer.org) if you have not
already.

```sh
git clone https://github.com/AndrewCarterUK/SimpleSite.git
composer install
```

These two commands will download this source code repository and use composer to
install some helpful packages to the 'vendor' directory.

Once you have done that, set up a development environment and point the document
root of the website to the 'public' directory.

Then have a look around and play!

Try these URLs and see what they give:

```
/
/hello/tom
/hello/andrew-carter
/rgwegweg
```

All the code is commented to try and help you understand what is going on under
the hood. Try adding more routes, more pages, more controllers, more templates
and more packages!
