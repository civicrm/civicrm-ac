# CiviCRM active contributors

A framework to track contributions and contributors to CiviCRM.

Tasks are recorded in many different systems. We poll those systems on a regular basis and record details of completed tasks (including the person that completed them) in the active contributor database.

# Data model

##Tasks

Tasks that have been completed.
##Sources

Places that we query for tasks

##Contacts

Contributors that have completed tasks

# How it works

A poll is defined for each type of task.  Each poll has a source (some polls share a source).

Polling a source conists of querying a source for results, transforming those results into tasks, attempting to assign a CiviCRM id for the contributor, and recording the tasks in the task database.

The task database can then be queried by various different sources. The task type and task external ID are declared as unique which means we can poll a source repeatedly and avoid duplicating tasks.

Currently, polling is carried out via the command line, for example:

```
bin/console app:poll commits # poll for commits in github yesterday
bin/console app:poll comments # poll for comments made on the website yesterday
bin/console app:poll merges # poll for merges closed in github yesterday
bin/console app:poll commits -d # delete yesterday's commits
bin/console app:poll commits -u # poll for yesterday's commits, updating any that have already been recorded
bin/console app:poll commits -f "2015-01-01" -t "2015-12-31" # poll for commits made in 2015
```

# Creating a poll

TODO

# Consuming this database

TODO

# Outstanding tasks

* Service that returns a CiviCRM contact ID when presented with an external ID and external ID type, e.g. https://co/api/contacts/find?email=michael@civicrm.org
* Prototype hall of fame
