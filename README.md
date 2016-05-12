# CiviCRM active contributors

A framework to track contributions and contributors to CiviCRM.

Tasks are recorded in many different systems. We poll those systems on a regular basis and record details of completed tasks (including the person that completed them) in the active contributor database so that they may be consumed in different places around the web, for example on the CiviCRM website or on the website of people or organisations that are contributing.

# Data model

##Tasks

Tasks that have been completed.

##Sources

Places that we query for tasks.

##Contacts

Contributors that have completed tasks.

# How it works

## Polling for tasks

A poll is defined for each type of task.  Each poll has a source. Some polls share a source.

Polling a source conists of querying a source for results, and transforming those results into tasks. As part of this transformation, we try and assign a CiviCRM contact id (as recorded in civicrm.org) for the contributor.

The task type and task external ID are declared as unique which means we can poll a source repeatedly and avoid duplicating tasks.

Currently, polling is carried out via the command line, for example:

```
app:poll commits # poll for commits in github yesterday
app:poll comments # poll for comments made on the website yesterday
app:poll merges # poll for merges closed in github yesterday
app:poll commits -d # delete yesterday's commits
app:poll commits -u # poll for yesterday's commits, updating any that have already been recorded
app:poll commits -f "2015-01-01" -t "2015-12-31" # poll for commits made in 2015
```

## Consuming tasks

A public read only API is available for consumption of tasks.

iframes are available so that you can embedd summary and detailed information on contributions made by individuals or organisations on arbitrary websites (TODO).

# Get involved

You're welcome to contribute to the active contributor framework. Your contributions will be recorded using the framework :poodle:.

## Creating a poll

If you're aware of an activity that we should be monitoring, feel free to create a Poll to create tasks based on this activity.

A couple of guidelines:

* Please ensure you are recording completed tasks, not commitments to carry out a task.
* It's a good idea to chat with someone in the active contributors working group about your Poll before getting started, so we can ensure that it makes sense to include in the framework.

Polls are services that are defined in the src/AppBundle/Utils/Poll/ directory and registered in app/config/services.yml (which typically injects a source into the service).

Your Poll service should extend `AppBundle\Utils\Poll` and define the following two methods:

### query()

Queries the source (available as `$this->source`), collects results in the array `$this->results`, and any errors in the array `$this->errors`.

### transform($result, $task)

Creates a $task with values from the $result. Tasks have the following properties

* type - set to the name of the poll
* subtype (optional) further classify this task
* externalIdentifier - this should be unique identifier for each type of task (ensuring that type+externalId is unique amongst the entire set of tasks) 
* date - the date that the task was completed
* url - A url that links to the task, or more details about the task
* description - a short summary of the task
* identiferString - a string uniquely identifies the contribuor that completed the task (e.g. joe@bloggs.com)
* identiferType - the type of identifier used for identify the contribtor (e.g. email)

# Todo

* More polls of more sources, including
    * stack-exchange
    * github pull requests
    * github issues
    * tweets(?)
* Move this todo list to github issues
* Read only API for general consumption of this data
* UI for consumption on civicrm.org (read only API)
* summary and detail views for all tasks
* iframe for embedding on other websites (read only API)
* Hall of fame for unknown contributors (i.e. people not linked to a contact in civicrm.org/civicrm)
* Task that updates identifiers (e.g. when they become known, or when civicrm contacts have become merged, etc.)
