# simpleheartbeatserver

A simple php heartbeat monitor to help keep an eye on scripts or processes you may leave running.

## Setup

Fork and deploy onto your server

modify the db connection details as appropriate - see `beats.php` line 3

run `beats.sql` in your database within the public schema

*Note* that this is set up to work seamlessly with Heroku and postgres

Please feel free to supplement for other setups


## Usage
Visit `/beats.php` to see latest heartbeats
use source to filter by sources
use since to filter by time in seconds (defaults to 3600 seconds)
example: `beats.php?source=test-source&since=300`

To leave a heartbeat, simply post to `/beats.php`
see `example.py` for a simple python example
