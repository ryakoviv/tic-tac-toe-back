#!/bin/sh

PHPUNIT_CMD="php -d memory_limit=-1 vendor/bin/phpunit --color=always"

testAll() {
    dependenciesUp
    ${PHPUNIT_CMD}
    EXIT_CODE=$?
    dependenciesDown
    exit ${EXIT_CODE}
}

testAllWithMetrics() {
    dependenciesUp
    ${PHPUNIT_CMD}  --coverage-html metrics
    EXIT_CODE=$?
    dependenciesDown
    exit ${EXIT_CODE}
}

dependenciesUp() {
    echo "Waiting dependencies..."
    echo "Dependencies are ready!!"
}

dependenciesDown() {
    echo "Dependencies are stopped!!"
}

case "$1" in
  test)
    testAll
    ;;
  metrics)
    testAllWithMetrics
    ;;
  *)
    echo "Usage: $0 {test|metrics|up|down}"
esac
