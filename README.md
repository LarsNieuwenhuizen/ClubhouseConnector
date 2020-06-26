<a href="https://codeclimate.com/github/LarsNieuwenhuizen/ClubhouseConnector/maintainability"><img src="https://api.codeclimate.com/v1/badges/9d0b03e99be71ba6c335/maintainability" /></a>
<a href="https://codeclimate.com/github/LarsNieuwenhuizen/ClubhouseConnector/test_coverage"><img src="https://api.codeclimate.com/v1/badges/9d0b03e99be71ba6c335/test_coverage" /></a>
[![Build Status](https://travis-ci.org/LarsNieuwenhuizen/ClubhouseConnector.svg?branch=master)](https://travis-ci.org/LarsNieuwenhuizen/ClubhouseConnector)

# Clubhouse connector

This library allows you to easily make use of
the Clubhouse api integrations through one connector.

## Early development stage | June 2020
This library is created recently and in a very early development stage.
So it will be subject to change a lot at this point in time.

You can test it if you want, but do not expect too much yet ;)

I will create more documentation when the base functionality is set. 

## Single point of entry
All you need to do is construct the Connector object with a configuration file.
The configuration is done throught yaml and looks like this.

#### config.yaml
```yaml
Clubhouse:
  api:
    uri: 'https://api.clubhouse.io/api/v3/'
    token: 'myApiTokenHere'
```

#### Creating the connector

```phph
$connector = new Connector('config.yaml');
```

#### Using clubhouse components
The components are accessed through their respective services like this:

```php
$connector->getEpicsService()->list();
```

This as you probably expects call the list of epics.
This will return you a collection on Epic objects.

## Objectification
All the Clubhouse resources will translated into Domain objects per component.

### Resource models and collections
All resource types will have their own Model and when retrieving multiple items,
the models will be gathered in IteratorAggregate Collections.

This is done so collections retrieved can be iterated over instantly and data is converted into
models, so we can use the data in a more specified way and make better use of the data later on.

So for example:

```php
$epics = $connector->epics()->list();

foreach ($epics as $epic) {
    echo $epic->getName();
    echo $epic->getCreatedAt()->format('d-m-Y');
}
```

## Using the services

There will be services created for all components within Clubhouse and subcomponents (labels, categories, comments etc...)

To use a service you'll access it throught the connector as described above.

### CRUD examples

1. Create an Epic

```php
$epic = new Epic();
$epic->setName('My first created Epic')
    ->setDescription('This is the description for my Epic');

$createdEpic = $connector->epics()->create($epic);
```

2. Update an existing Epic
```php
$existingEpic = $connector->epics()->get(1);
$existingEpic->setName('A new name for this Epic');

$updatedEpic = $connector->epics()->update($existingEpic);
```

3. Delete an Epic
```php
$connector->epics()->delete(1);
```

4. List all Epics
```php
$collection = $connector->epics()->list();
```

## Magic methods
The method and variable names I used in the connector are like `getEpicsService()`
But to make it a bit more relatable with Clubhouse naming and simply a bit shorter,
I added magic method calls for the services.

So instead of calling `$connector->getEpicsService()->list()`
You can also call `$connector->epics()->list()`
