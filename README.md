ElaoFormTranslationBundle
=========================

![](https://img.shields.io/badge/Symfony-2.6-blue.svg)
[![Build Status](http://api.travis-ci.org/Elao/ElaoFormTranslationBundle.png)](http://travis-ci.org/Elao/ElaoFormTranslationBundle)

Description:
--------------

This bundle provides a nice way of generating translation keys for form fields in a "logic" way.
It is used mainly to generate automatic labels on fields but can be use to build any key.

__For example, in a form `RegisterType` named "register" the key for its field "name" would be `form.register.children.name.label`.__

Another more advanced example would be a field "emails" which is a `collection` of `text` inputs, it'll generate:

- `form.register.children.emails.label`
- `form.register.children.emails.label_add`
- `form.register.children.emails.label_delete`
- `form.register.children.emails.children.prototype.label`

Or in `yml`:

``` yml
form:
    register:
        children:
            emails:
                label:          # add your trans for the fieldset ex: Email
                label_add:      # add your trans for add button ex: Add an email
                label_delete:   # add your trans for remove button ex: Remove an email
                children:
                    prototype:
                        label:  # add your trans for the label of one email field ex: Email address
```

_Note: The keys will only be generated at runtime and won't be dumped when you use `translation:update` yet (we're working on it)._

Installation:
--------------

Add ElaoFormTranslationBundle to your composer.json:
``` json
{
    "require": {
        "elao/form-translation-bundle": "1.2.*"
    }
}
```

Now download the bundle by running the command:

``` bash
$ php composer.phar update elao/form-translation-bundle
```

Register the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Elao\Bundle\FormTranslationBundle\ElaoFormTranslationBundle(),
    );
}
```

How to use it:
--------------

In order to generate translation keys automatically, you have 2 options:

#### Per field generation:

If you set the the "label" option of a form field to __true__, a key will be generated and set as the field label.
__Otherwise we won't generate your labels !__

``` php
<?php

class RegisterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => true // Will generate: "form.register.children.name.label"
            ));
            ->add('email', null, array(
                'label' => false // Will NOT generate a `<label>` in the `HTML`
            ));
            ->add('email', null, array(
                'label' => 'my.custom.key' // Default behavior
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'register';
    }
}
```

#### Global configuration key:

If you want to generate keys for all your labels you can set the option `auto_generate` to `true`:

    elao_form_translation:
        auto_generate: true

This will set default label value to `true` so keys will be generated for every label.

If you need to override this behavior, you can still provide a `label` key for your field in order to use your translation key. In this case, no keys will be generated.


Customization and configuration:
--------------

#### Customize the keys:

Keys are built following this pattern:

    [root][separator](parent_field_name)[separator][children][separator](field_name)[key]

You can customize (and remove) any of these tokens to change the way keys are built:

``` yml
elao_form_translation:
    blocks:
        # Prefix for children nodes (string|false)
        children:   "children"

        # Prefix for prototype nodes (string|false)
        prototype:  "prototype"

        # Prefix at the root of the key (string|false)
        root:       "form"

        # Separator te be used between nodes (string|false)
        separator:  "."
```

For example, if you just need simple keys you could do with the following configuration:

``` yml
elao_form_translation:
    blocks:
        root:      false
        children:  false
        separator: "_"
```
Which would generate that kind of keys:

    # (parent_field_name)[separator](field_name)[separator][key]
    register_name_label

#### Default configuration:

``` yml
elao_form_translation:

    # Can be disabled
    enabled: true

    # Generate translation keys for all missing labels
    auto_generate: false

    # Customize available keys
    keys:
        form:
            label:  "label"
            help:   "help"
            # Add yours ...
        collection:
            label_add:      "label_add"
            label_delete:   "label_delete"
            # Add yours ...

    # Customize the ways keys are built
    blocks:

        # Prefix for prototype nodes
        prototype:  "prototype"

        # Prefix for children nodes
        children:   "children"

        # Prefix at the root of the key
        root:       "form"

        # Separator te be used between nodes
        separator:  "."
```
