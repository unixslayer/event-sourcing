# unixslayer/event-sourcing

[![Travis (.org)][ico-travis]][link-travis]
[![Coveralls github][ico-coverage]][link-coverage]
[![GitHub release (latest by date)][ico-release]][link-release]
[![GitHub][ico-license]](LICENSE.md)

Basic implementation of Event Sourcing due to fact that [prooph/event-sourcing](https://github.com/prooph/event-sourcing) is abandoned. If you are looking for Aggregate repository, check out [unixslayer/event-store](https://github.com/unixslayer/event-store).

## Installation

You can install this via composer by running `composer require unixslayer/event-sourcing` or adding it as requirement to your composer.json

## Usage

This library comes with basic implementation of Event Sourcing which is only two classes:

- aggregate root
- aggregate event

This repository is inspired from Prooph solution with assimption of being independent from any framework. If you are familiar with [prooph/event-sourcing](https://github.com/prooph/event-sourcing), you'll know what to expect. Otherwise, check out Prooph's repository or [tests](./tests/Domain/CartTest.php).

## Support

I strongly recommend for implementing Event Sourcing by your own. You can accomplish that in a way described [here](https://unixslayer.github.io/how-i-did-my-own-implementation-of-event-sourcing) and [here](https://unixslayer.github.io/implementing-aggregate-repository) or [here](https://github.com/prooph/documentation/blob/master/event-store-client/blueprints.md). 
If for some reason you find this library useful and use it, feel free to file an issue. Also, PR will be awesome.

[ico-travis]: https://img.shields.io/travis/unixslayer/event-sourcing
[ico-coverage]: https://img.shields.io/coveralls/github/unixslayer/event-sourcing
[ico-release]: https://img.shields.io/github/v/release/unixslayer/event-sourcing
[ico-license]: https://img.shields.io/github/license/unixslayer/event-sourcing

[link-travis]: https://travis-ci.org/unixslayer/event-sourcing
[link-coverage]: https://coveralls.io/github/unixslayer/event-sourcing
[link-release]: https://github.com/unixslayer/event-sourcing/releases
[link-license]: LICENSE.md