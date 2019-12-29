# CodeIgniter WebSockets Authorization
### Description
by [Medet Ahmetson]

Authentication System for your WebSocket Servers written by [Ratchet PHP](https://github.com/ratchetphp/Ratchet) and CodeIgniter framework.

It's based on [Ion Auth 3](https://github.com/benedmunds/CodeIgniter-Ion-Auth). **Ws Auth** changed the underlying code, without affecting the interface, to able the simple and easy to use Auth Lib for Ratchet PHP.

Since, the command interface of **Ws Auth** is the same as API of **IoN Auth 3**, the documentation of IoN could be also used for Ws Auth library.

*NOTE! Ws Auth doesn't support native Sessions*

## Server requirements

**CodeIgniter 3** &ndash; a popular Framework

**Php 5.6**

**RatchetPHP** &ndash; a popular WebSocket library written on PHP

*Ws Auth* also could be used without RatchetPHP, but include symfony sessions as WebSocket dependency at composer.json.

## Documentation
Documentation is located at http://benedmunds.com/ion_auth/

## Upgrading
See [UPGRADING.md](UPGRADING.md) file.

## Installation
See [INSTALLING.md](INSTALLING.md) file.

## Usage
In the package you will find example usage code in the controllers and views
folders.  The example code isn't the most beautiful code you'll ever see but
it'll show you how to use the library and it's nice and generic so it doesn't
require a MY_controller or anything else.

### Default Login
Username: admin@admin.com
Password: password


### Important
It is highly recommended that you use encrypted database sessions for security!


## Support
If you think you've found a bug please [Create an Issue](https://github.com/ahmetson/CodeIgniter-Ws-Auth/issues).

If you need any help implementing Ws Auth into your project please [Email Me for Consulting Information](mailto:admin@blocklords.io).


