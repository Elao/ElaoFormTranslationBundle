ElaoFormTranslationBundle
=========================

Description:
--------------

This bundle provides a nice way of generating translation keys for form fields in a way you can easily deduce them.
It's used mainly to generate automatic labels on fields but can be use to built any key.

__For example, in a form `RegisterType` named "register" the key for its field "name" would be `form.register.name.label`.__

Another more advanced example would be a field "emails" which is a `collection` of `text` intputs, it'll generate :

- `form.register.emails.label`
- `form.register.emails.label_add`
- `form.register.emails.label_delete`
- `form.register.emails.children.prototype.label`

Or in `yml` :

``` yml
form:
    register:
        emails:
            label:          # add your trans for the fieldset ex: Email
            label_add:      # add your trans for add button ex: Add an email
            label_delete:   # add your trans for remove button ex: Remove an email
            children:
                prototype:
                    label:  # add your trans for the label of one email field ex: Email address
```

_Note : The keys will only be generated and won't be dumped when you use `translation:extract`._

Installation:
--------------

Add FOSUserBundle in your composer.json:
``` js
{
    "require": {
        "elao/form-translation-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update elao/form-translation-bundle
```

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Elao\FormTranslationBundle\ElaoFormTranslationBundle(),
    );
}
```

How to use it:
--------------

In order to generate automatically translation keys, you have 2 options :

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
                'label' => true // Will generate : "form.register.name.label"
            ));
            ->add('email', null, array(
                'label' => false // Will NOT generate a `<label>` in the `HTML`
            ));
            ->add('email', null, array(
                'label' => 'my.custom.key' // Will generate 'my.custom.key'
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

If you want to generate keys for all your labels you can set the option `auto_generate_label` to `true` :

    elao_form_translation:
        auto_generate: true

This will set default label value to `true` so keys will be generated for every labels.

If you need to override this behaviour, you can still provide a `label` key for your field in order to use your translation key. In this case, no keys will be generated.


Customization and configuration:
--------------

#### Customize the keys:

If for a reason or another you need to customize the key for example instead of using "form.register.name.label" you want to use "my_custom_key.register.name.label", you'll have to update the `root` configuration key under `blocks` key.

``` yml
elao_form_translation:
    blocks:
        # Prefix for children nodes
        children:   "children"

        # Prefix for prototype nodes
        prototype:  "prototype"

        # Prefix at the root of the key
        root:       "form"

        # Separator te be used between nodes
        separator:  "."
```

#### Default configuration:

``` yml
    elao_form_translation_translation:
        enabled: true

        # Generate translation keys for all missing labels
        auto_generate_label: false

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
