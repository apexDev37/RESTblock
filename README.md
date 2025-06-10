# REST Block
> Custom Gutenberg block plugin to integrate proprietary services with the WordPress API.

 <img src="https://novo-media.ch/app/uploads/2018/09/gutenberg-wordpress.jpg" width="25%" alt="WordPress + Gutenberg logo"/>

[![status: archived](https://img.shields.io/badge/status-archived-red.svg)](https://docs.github.com/en/repositories/archiving-a-github-repository/archiving-repositories)
> ⚠ **Note:** This repository has been **archived** and is no longer maintained.
```
This project was created in preparation for my Backend Engineer role at IBL Education (now ibl.ai) back in 2023.
It is no longer in active use, and there are no current or future plans to contribute to or develop this repository further.

The code and history remain available for reference. Feel free to browse or fork, but please be aware that:
- Issues and pull requests are disabled
- No support or updates will be provided

Thanks for your interest!
```

## Introduction
Learn more about developing custom blocks from the official [documentation].

## Installing / Getting started
This is an overview of the minimal setup needed to get started.

### Prerequisites
- [Git]
- [Docker]
- [Docker Compose]
- [Docker Desktop]
- [Node v14.0.0+]
- IDE/Code/Text editor (PHPStorm, VScode, Vim, etc)

Follow these tutorials on setting up Docker and Compose on either [Mac] or [Linux].
I'd recommend Microsoft's documentation to set up [Docker on WSL2] if you're on Windows.

Use this [guide] to install on your host machine Node v14, which is the recommended version in the custom block developer handbook. 

### Local Setup
> The following setup was run on Ubuntu Focal (20.0.4 LTS)

You can clone this repo with the following command.

- Clone the repository
``` bash
    # cd your/desired/target/dir
    $ git clone https://github.com/apexDev37/RESTblock.git restblock
    $ cd restblock
```

> This will clone the repository to a target directory on your host machine and navigate into its root directory.

### Configuration
Before running WordPress with Docker Compose, configure the required environment variables defined in the `./configuration` directory. Example `env` files are provided to configure the following instances: WordPress, MySQL, and phpMyAdmin.  
You can create `env` files with the following code snippet.

- Create env files
``` bash
    # ensure you're in the project's root
    $ for file in .envs/*.example; do cp "$file" "${file%.example}"; done
    $ cd .envs/
```

> This will loop through all the files in `./configuration/` that end with `.example` and create new files without the `.example` extension (ie, `mysql.env.example` -> `mysql.env`).

[//]: # (These are reference links used in the body of this note and get stripped out when the markdown processor does
its job. There is no need to format nicely because it shouldn't be seen.
Thanks SO - http://stackoverflow.com/questions/4823468/store-comments-in-markdown-syntax)

<!-- Introduction links -->
[documentation]: <https://developer.wordpress.org/block-editor/>

<!-- Installing / Getting Started links -->
[Git]: <https://git-scm.com/>
[Docker]: <https://www.docker.com/>
[Docker Compose]: <https://docs.docker.com/compose/>
[Docker Desktop]: <https://www.docker.com/products/docker-desktop/>
[Node v14.0.0+]: <https://nodejs.org/en/blog/release/v14.17.3>
[Mac]: <https://docs.docker.com/desktop/install/mac-install/>
[Linux]: <https://docs.docker.com/desktop/install/linux-install/>
[Docker on WSL2]: <https://learn.microsoft.com/en-us/windows/wsl/tutorials/wsl-containers>
[guide]: <https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-22-04>
