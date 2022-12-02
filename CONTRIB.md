# Contributing to the ToDoList project

First off, thanks for taking the time to contribute! ❤️

All types of contributions are encouraged and valued.
See the [Table of Contents](#table-of-contents) for different ways to help and details about how this project handles
them.
Please make sure to read the relevant section before making your contribution.
It will make it a lot easier for us maintainers and smooth out the experience for all involved.
The ToDo&Co team looks forward to your contributions. 🎉

> And if you like the project, but just don't have time to contribute, that's fine. There are other easy ways to support
> the project and show your appreciation, which we would also be very happy about:
> - Star the project :star:
> - Tweet about it  :bird:
> - Refer this project in your project's readme :link:
> - Mention the project at local meetups and tell your friends/colleagues :loudspeaker:

## Table of Contents

- [I Have a Question](#i-have-a-question)
- [I Want To Contribute](#i-want-to-contribute)
  - [Reporting Bugs](#reporting-bugs)
  - [Suggesting Enhancements](#suggesting-enhancements)
  - [Your First Code Contribution](#your-first-code-contribution)
    - [Git branches](#git-branches)
    - [Commits](#commits)
    - [Testing](#testing)
    - [Code Quality chores](#code-quality-chores)
  - [Improving The Documentation](#improving-the-documentation)
    - [A few tips regarding documentation](#a-few-tips-regarding-documentation)
- [Styleguides](#styleguides)
  - [Commit Messages](#commit-messages)

## I Have a Question

> If you want to ask a question, we assume that you have read the
> available [Documentation](https://stlgaits.github.io/todo).

Before you ask a question, it is best to search for existing [Issues](https://github.com/stlgaits/todo/issues) that
might help you. In case you have found a suitable issue and still need clarification, you can write your question in
this issue. It is also advisable to search the internet for answers first.

If you then still feel the need to ask a question and need clarification, we recommend the following:

- Open an [Issue](https://github.com/stlgaits/todo/issues/new).
- Provide as much context as you can about what you're running into.
- Provide project and platform versions (nodejs, npm, etc), depending on what seems relevant.

We will then take care of the issue as soon as possible.

## I Want To Contribute

> ### Legal Notice <!-- omit in toc -->
> When contributing to this project, you must agree that you have authored 100% of the content, that you have the
> necessary rights to the content and that the content you contribute may be provided under the project license.

### Reporting Bugs

#### Before Submitting a Bug Report

A good bug report shouldn't leave others needing to chase you up for more information. Therefore, we ask you to
investigate carefully, collect information and describe the issue in detail in your report. Please complete the
following steps in advance to help us fix any potential bug as fast as possible.

- Make sure that you are using the latest version.
- Determine if your bug is really a bug and not an error on your side e.g. using incompatible environment
  components/versions (Make sure that you have read the [documentation](https://stlgaits.github.io/todo). If you are
  looking for support, you might want to check [this section](#i-have-a-question)).
- To see if other users have experienced (and potentially already solved) the same issue you are having, check if there
  is not already a bug report existing for your bug or error in
  the [bug tracker](https://github.com/stlgaits/todoissues?q=label%3Abug).
- Also make sure to search the internet (including Stack Overflow) to see if users outside the GitHub community have
  discussed the issue.
- Collect information about the bug:
  - Stack trace (Traceback)
  - OS, Platform and Version (Windows, Linux, macOS, x86, ARM)
  - Version of the interpreter, compiler, SDK, runtime environment, package manager, depending on what seems relevant.
  - Possibly your input and the output
  - Can you reliably reproduce the issue? And can you also reproduce it with older versions?
  - Add screenshots if it's a visual bug

#### How Do I Submit a Good Bug Report?

> You must never report security related issues, vulnerabilities or bugs including sensitive information to the issue
> tracker, or elsewhere in public. Instead sensitive bugs must be sent by email to <estelle.gaits@gmail.com>.

We use GitHub issues to track bugs and errors. If you run into an issue with the project:

- Open an [Issue](https://github.com/stlgaits/todo/issues/new) and if it is a bug, add the **bug** label.
- Explain the behaviour you would expect and the actual behaviour.
- Please provide as much context as possible and describe the *reproduction steps* that someone else can follow to
  recreate the issue on their own. This usually includes your code. For good bug reports you should isolate the problem
  and create a reduced test case.
- Provide the information you collected in the previous section.

Once it's filed:

- A team member will try to reproduce the issue with your provided steps.
- If the team is able to reproduce the issue, it will be left to
  be [implemented by someone](#your-first-code-contribution).

### Suggesting Enhancements

This section guides you through submitting an enhancement suggestion for ToDoList, **including completely new features
and minor improvements to existing functionality**. Following these guidelines will help maintainers and the community
to understand your suggestion and find related suggestions.

#### Before Submitting an Enhancement

- Make sure that you are using the latest version.
- Read the [documentation](https://stlgaits.github.io/todo) carefully and find out if the functionality is already
  covered, maybe by an individual configuration.
- Perform a [search](https://github.com/stlgaits/todo/issues) to see if the enhancement has already been suggested. If
  it has, add a comment to the existing issue instead of opening a new one.
- Find out whether your idea fits with the scope and aims of the project. It's up to you to make a strong case to
  convince the project's developers of the merits of this feature. Keep in mind that we want features that will be
  useful to the majority of our users and not just a small subset. If you're just targeting a minority of users,
  consider writing an add-on/plugin library.

#### How Do I Submit a Good Enhancement Suggestion?

Enhancement suggestions are tracked as [GitHub issues](https://github.com/stlgaits/todo/issues) and tagged with the **
enhancement** keyword.

- Use a **clear and descriptive title** for the issue to identify the suggestion.
- Provide a **step-by-step description of the suggested enhancement** in as many details as possible.
- **Describe the current behaviour** and **explain which behaviour you expected to see instead** and why. At this point
  you can also tell which alternatives do not work for you.
- You may want to **include screenshots**
- **Explain why this enhancement would be useful** to most ToDoList users. You may also want to point out the other
  projects that solved it better and which could serve as inspiration.

<!-- You might want to create an issue template for enhancement suggestions that can be used as a guide and that defines the structure of the information to be included. If you do so, reference it here in the description. -->

### Your First Code Contribution

To set up the project, refer the README.md section of the project.

#### Git branches

![git flow: master branch with dev, feature & tests](gitflow.png)

Before adding to the project, please first make sure that you have cloned the whole project and that you are up to date
using **git pull**.
This project was built using the following branching method:

| branch name | use case                                                                                                                                                          | created from which branch ? | who can push on it? | where should merge PRs go to? |
|-------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------|---------------------|-------------------------------|
| main        | The production branch :lock:                                                                                                                                      | N/A                         | admins only         | N/A                           |
| docs        | The documentation branch. NB: please make sure that you only make changes to the /docs folder on this branch.                                                     | main                        | anyone              | main                          |
| hotfix      | In case of emergency only. This is used when a major bug has occurred in production and requires fixing immediately :rotating_light: :lock: :hammer:              | main                        | admins only         | main                          |
| dev         | Centralises all ongoing features & bugfixes. This branch is where you should always start from (99% of the time). :sparkles:                                      | main                        | admins only         | main                          |
| tests       | Where anything related to testing happens (PHPUnit config, coverage reports, unit, integration and functional tests, etc). :elephant:                             | dev                         | anyone              | dev                           |
| my-feature  | Where the magic happens : this is your branch, where you will make all your feature developments. Each feature should have its own dedicated branch. :magic_wand: | dev                         | anyone              | dev                           |
| my-bugfix   | Very similar to a feature branch, except it is used to fix a minor bug. :wrench: :hammer:                                                                         | dev                         | anyone              | dev                           |

#### Commits

We advise that you commit often and frequently. The more frequent & the shorter, the better. However, in order to avoid
conflicts, please also ensure
that you _git pull_ regularly too before pushing.

Here is the usual sequence :

````git
git checkout dev
git pull
git checkout -b mynewfeature
````

Then, start writing your code, commit & push to new remote branch.

````git
git status 
git diff
git add .
git commit -m 'feat: add incredible feature which does insane things'
git push
````

#### Testing

> We strongly recommend adopting a _Test Driven Development_ approach (if you're not familiar with TDD, you can find
> more details [here](https://martinfowler.com/bliki/TestDrivenDevelopment.html)).

Please make sure that each new feature or bugfix you contribute is duly tested by writing unit, integration & functional
tests.

Tests should be written in the /tests folder of the application & follow the convention already in place, which is to
separate folders & files
the same way they are split in the /src folder.

In order for your tests to pass, you first need to create a test database using a .env.test.local file with your test
DATABASE_URL (conventionally, it is the same as the production one, following by **_test**).
Then, you need to load test fixtures (the ones located in the /fixtures folder), which are built using
AliceFixturesBundle.

To do so, run :

````git 
php bin/console --env=test doctrine:database:create
php bin/console --env=test doctrine:fixtures:load --append
````

To run your test, run the following command :

````php
./vendor/bin/phpunit tests --colors=always --testdox
````

The 2 flags are optional but allow you the visualise your tests in a more user-friendly way with colors.

To update the app's code coverage report, run the following command to generate an HTML report which you may then view
in your web browser :

````php
./vendor/bin/phpunit  --coverage-html coverage.html
````

or simply run this command if you only want to generate the clover.xml report which will be sent to Codacy.

````php
./vendor/bin/phpunit  --coverage-clover clover.xml
````

Then, once all tests have passed, you may commit your changes as well as the code coverage reports and push them onto
the **tests** branch, then
create a merge pull request from **tests** to **dev**.
If they are approved by the team, your changes will then be merged onto the main branch & a new Release with release
notes will be published.

#### Code Quality chores

In order to guarantee consistency and enforce best practices regarding code quality, this project is monitored by Codacy
for static analysis.
Therefore, we ask that before pushing a commit to the remote repo, you perform a few code quality / clean up tasks.

##### PHPCSFixer

Firstly, please run [PHPCSFixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) on the **/src** & **/tests** folders of
the app, using the following command :

````git
./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix tests/ src/
````

This will lint your code. Make sure to commit your changes and prefix them with a **chore** keyword.

##### PHPStan : bug bounty

Additionally, we very strongly encourage scanning your code with [PHPStan](https://phpstan.org/). This tool will help
you detect bugs in your source code without needing to launch a debugger.
PHPStan scans your code using several levels of configuration (from 0 to 9). The recommended usage is to first launch a
scan at level 0 and go all the way up, while fixing potentially reported bugs each step of the way.

The command to run a scan is the following :

````git
./vendor/bin/phpstan analyse -l 0 src
./vendor/bin/phpstan analyse -l 1 src
./vendor/bin/phpstan analyse -l 2 src 

... etc ...

./vendor/bin/phpstan analyse -l 9 src 
````

You should run this command on both /src & /tests folders.

#### Codacy : static analysis

This project is synced with [Codacy](https://app.codacy.com/gh/EstelleMyddleware/todo/dashboard), a static code analysis
tool & dashboard & includes
a [Codacy scan GitHub Actions workflow](https://github.com/stlgaits/todo/blob/main/.github/workflows/codacy.yml).
Therefore, each PR towards the dev & main branch will trigger a static code analysis as well as a code coverage report
update. If, for some reason, Codacy detects errors or bugs in your commit, please go to
the [issues dashboard](https://app.codacy.com/gh/EstelleMyddleware/todo/issues) and read
the information available there to decide whether you should fix the error.

### Improving The Documentation

We ask that, as you make further additions to the source codebase, you simultaneously update, improve and correct the
project's documentation.
To do so, you will need to install [DocsifyJS](https://docsify.js.org/#/).
The documentation files are located in the **/docs** folder of the application. You need to be familiar with **
markdown** syntax and conventions before startin to write.
To update the documentation, use the **docs** git branch and push your commits there.
Once you are satisfied with your changes, please create a merge pull request directly towards the **main** branch.
Once merged, your changes will be automatically deployed via GitHub Pages there :
**https://stlgaits.github.io/todo.** :rocket: :rocket: :rocket: :rocket:

#### A few tips regarding documentation

- Do not document the future ! If you haven't deployed a feature in production yet, there is no need to talk about it
  yet ! Project features and priorities may change over time, we do not want to confuse our users.
- Read the [DocsifyJS](https://docsify.js.org/#/) documentation first. It is very intuitive and user-friendly. If you're
  a French speaker, you can watch this Getting Started
  Tutorial : [Estelle Gaits - Introduction à Docsify.js](https://www.youtube.com/watch?v=SGZfVd0osCE)

## Styleguides

### Commit Messages

> We **very strongly** encourage you to install [devpolo/gac]( https://github.com/devpolo/gac) on your computer as it
> allows you to write faster commit messages and embarks the keywords listed below.

We ask that you follow our commit policy & best practices :

- commit messages must be written in English
- commit messages must start with a key word from the following list :

| keyword      | when to use ?                                                                                                                                                                                                                                           |
|--------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **feat**     | When developing a new feature for the app's **users** (something users can do, this DOES NOT include background code / scripts)                                                                                                                         |
| **fix**      | When repairing a bug for **users**                                                                                                                                                                                                                      |
| **docs**     | When adding to, updating, correcting the project's documentation, which is located inside the **/docs** folder. docs commit should be made on the **docs** branch & merge PRs should be made towards main directly.                                     |
| **style**    | When formatting **code** without affecting users. This includes modifications such as indentation, missing semi-colon, etc. :warning: This should not be confused with frontend styles (CSS). Here, styles is to be understood as code **formatting**   |
| **refactor** | When refactoring production code. For instance, renaming a variable, removing duplicates, fixing deprecations, chopping a large function into multiple methods, etc.                                                                                    |
| **test**     | When adding unit, integration or functional tests, refactoring tests, adding code coverage reports,... Production code is not changed.                                                                                                                  |
| **chore**    | When performing 'clean up' tasks & production code is not changed as a result. For instance, updating build tasks, updating dependencies via package managers (composer, yarn, npm,...)                                                                 |

- commit messages' second word must be a **verb** in the imperative mood. That verb should give the most accurate
  description possible of the changes made (add, remove, implement, instantiate,...)
- commit messages should aim to accurately describe **why** a change was made and **how** it fixes a problem
- commit messages should be _sorted_ in a way that the most important facts are at the beginning of the message
- commit messages should NOT end with a full stop
- commit messages should be no longer than _72 characters_
- commit messages should be written in a way that never assumes that the commit's reader will know which issue or
  feature it is referring to. The aim is for commit messages to be readable by anyone outside the project.
- when the current code is lacking something or needs to be fixed, this should be explained explicitly for future
  developers to be able to take over where you left off.
- when referring a GitHub Issue, make sure to refer to that issue at the end of your commit message by adding a link to
  the issue. GitHub will manage that link to make a reference to your commit there.

<!-- omit in toc -->

## Attribution

This guide is based on the **contributing-gen**. [Make your own](https://github.com/bttger/contributing-gen)!