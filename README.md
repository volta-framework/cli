# Volta\Component\Cli

This component contains helpers for small php apps/scripts.

## When not to use
This is not a full stack library to build complex CLI applications. If this is what you need see Symphony/Console Component.

https://symfony.com/doc/current/components/console.html

## When to use

The component mainly exists of (a) helper(s) which can aid small scripts usually with a codebase no more than a few 100 lines to be executed on the command line. It wil help to color and organize your output. It wil provide a Wrapper class around the setopt() for user input.