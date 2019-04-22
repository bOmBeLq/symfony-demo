Symfony demo app
==================
This repo serves as demonstration of sample implementation of CRUD's with symfony framework.

### Usage

#### Hosts manager

First make sure you have https://github.com/iamluc/docker-hostmanager installed. 
Host manager automatically updates your hosts file. 
If you skip this you will have to manually add hosts entry to view running app in browser.

#### Setup
Run:
```
git clone git@github.com:bOmBeLq/symfony-demo.git
bin/setup.sh
```
setup.sh will setup docker and install all required dependencies

Then you should be able to access running ap under
`http://webserver.symfony-demo.local`

### Using docker
By default docker runs as root user. 
This introduces problem when files are generated inside docker
and you are trying to edit them in IDE which usually is not running as root.
That's why I've modified Dockerfile a little and if you would be running `docker-composer build/up` manually then you would have to pass UID variable to id.
This is so we can create user inside docker instance matching your local user.

Then to enter into docker as your host user use `./docker.sh`.
You can use `./docker.sh` to run commands inside container as your local user.
Like for example:
```
./docker.sh composer require some/dependency
./docker.sh app/console doctrine:database-drop
etc.
```
### Testing
App uses codeception as testing framework.
To run tests simply run
`./docker.sh vendor/bin/codeception run`

### Developement

@todo describe encore usage

### Todo
1. Find out why Blameable does not work in codeception
1. Add more tests (see makrTestIncomplete in test files)
1. Add registration
1. Add some more complicated functionalities to show usage of services DI and maybe some unit tests.
1. Separate DB for tests