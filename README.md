# unixslayer/event-sourcing

[![Tests Status][ico-tests]][link-tests]
[![Analyse Status][ico-analysis]][link-analysis]
[![Coverage Status][ico-coverage]][link-coverage]
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

[ico-tests]: https://github.com/unixslayer/event-sourcing/actions/workflows/tests.yml/badge.svg
[ico-analysis]: https://github.com/unixslayer/event-sourcing/actions/workflows/static-analysis.yml/badge.svg
[ico-coverage]: https://coveralls.io/repos/unixslayer/event-sourcing/badge.svg?branch=master&service=github
[ico-release]: https://img.shields.io/github/v/release/unixslayer/event-sourcing
[ico-license]: https://img.shields.io/github/license/unixslayer/event-sourcing

[link-tests]: https://github.com/unixslayer/event-sourcing/actions/workflows/tests.yml
[link-analysis]: https://github.com/unixslayer/event-sourcing/actions/workflows/static-analysis.yml
[link-coverage]: (https://coveralls.io/github/unixslayer/event-sourcing?branch=master)
[link-release]: https://github.com/unixslayer/event-sourcing/releases
[link-license]: LICENSE.md
