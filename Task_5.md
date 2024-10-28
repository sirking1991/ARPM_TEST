# Task_1
https://docs.google.com/spreadsheets/d/1rUqqbdUIu0yWFsO3bqvNEnozg57w2YFVQ0m93_HwHOI/edit?usp=sharing

# Task_2
OrderController.php

# Task_3
SpreadSheetTest.php

# Task_4
WriteAnElegantCode.php

# Task_5
## A - Explain the code
It's a Laravel scheduler that will:
- run the `app:example-command`
- prevent overlapping existing process of the same schedule command
- run hourly
- execute strictly on one server,
- create a new process to run the command

## B - What is the difference between the Context and Cache Facades? Provide examples to illustrate your explanation.
- Context refer to the current state of the code execution.
- Cache Fascade is a static function use to cache data for use at a later time. This helps in improving data retrieval. There are different drivers available
for use in caching, redis, database, file and others.

## C - What's the difference between $query->update(), $model->update(), and $model->updateQuietly() in Laravel, and when would you use each?
- `$query()->update()` is use is you want to update several records that will match the condition. It is use in query builder object
- `$model->update()` is use to update a specific eloquent model. This will trigger eloquent model events `updating` & `updated`
- `$model->updateQuietly()` - similar to `$model->update()`, except that it does not trigger the events. Useful when you want to update a model instance without firing events, which can be helpful in scenarios where you want to avoid side effects or performance overhead from event listeners.
