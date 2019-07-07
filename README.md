# Spectre Technical Test

This test was created for the purpose of the Spectre Technical Test.

To run the code, simply use PHP CLI:

`php index.php <path/to/file.csv>`

where `<path/to/file.csv>` should be your own file path to the CSV to load

## Logging

Please note that this application logs to stdout when it cannot process what it perceives to be a valid
row. It will also output the array using the `var_dump()` function, the result of the calls.
 

## Assumptions

I have made the assumptions that all fields, with the exception of "homeowner" are valid, and
as a result I have made changes to the code that go beyond that of the original examples.

I assume where a record comes in as `Mr and Mrs John Smith` that `John` belongs to the first person
and that we do not know the first name of the second person, giving us `Mr John Smith` and `Mrs Smith`.

## Requirements

This application was written with the support of PHP version 7.2 and is not guaranteed to 
work under this version.

## Future improvements

It would have been better to have split the reading of CSV into another class, so as to allow
the responsibility of the Converter to simply convert.

It would have been better to use custom Exceptions, rather than the generic one.

Logging could have been done using monolog rather than stdout.