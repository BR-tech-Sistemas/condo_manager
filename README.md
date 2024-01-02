
![Logo do projeto](https://i.imgur.com/pUTXM4h.png)

# LaraFilaSkeleton

This repository is a Skeleton of the Latest Laravel with FilamentPHP and docker.

## 🔥 Introduction

This repository aim to speed up the time to start new projects that is built upon Docker, Laravel and FilamentPHP.

You'll need just some quick steps to focus on what matters, `coding!` 

### ⚙️ Prerequisites

You'll just need the follow technologies:

- Git
- Docker


### 🔨 How to Start

Here is the steps need to start your next project.

1. **First, let's clone the repository:**
    ```bash
    git clone https://github.com/Braiani/LaraFilaSkeleton.git project-name
    ```
    ```bash
    cd project-name
    ```
    Remember to change the `prject-name` with the name of your project
2. **After clone, it's time to remove the git folder of the LaraFilaSkeleton:**

    ```bash
    sudo rm -R .git/
    sudo rm -R .github/
    ```
3. **Now, let's copy the `.env.default` file:**

    ```bash
    cp .env.default .env
    ```
    Edit the new `.env` file as you need, we recommend you to change the following variables:
    * APP_NAME
    * APP_URL
    * APP_LOCALE
    * APP_TIMEZONE
    * DB_DATABASE
    * DB_USERNAME
    * DB_PASSWORD

4. **After edit the fields you judge necessary, it's time to build and run the containers:**
    ```bash
    docker-compose up -d
    ```
5. **Alternatively, you can first build and the run the container:** 
    ```bash
    docker-compose build
    ```
   ```bash
    docker-compose up -d
    ```
****

### With everything done, we can execute our Laravel's container and run some Laravel code:

1. **First, let's jump into the container:**
    ```bash
    docker exec -it laravel_project-name /bin/bash
    ```
    Ps: The name after the `-it` is the Laravel's container name, by default it's the following: `laravel_LaraFilaSkeleton`.
2. **When inside the container, we need to generate the key, migrate the database and seed with the Admin user:**
    ```bash
    php artisan key:generate
    ``` 
    ```bash
    php artisan migrate --seed
    ``` 
****

That's all we need.

Now, just go to localhost and make sure everything is running ok!

Try accessing the admin area [http://localhost/admin](http://localhost/admin)

The default credentials are:

- e-mail: `admin@admin.com`
- password: `password`

****

## 📦 What we use here:

* [![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/)
* [![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white)](https://www.docker.com/)
* [![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com/)
* [FilamentPHP](https://filamentphp.com/)

## 👷 Author

1. **Felipe Braiani** - *Developer/[CEO of BR tech Sistemas](https://brtechsistemas.com.br/)* - [Braiani](https://github.com/Braiani)

## 📄 License

This repository is licensed under MIT License, you can see more details on [LICENSE.md](https://github.com/link_da_licenca).


## 💡 Support

* If you want to support the project, you can either open an PR or e-mail me [felipe@brtechsistemas.com.br](mailto:felipe@brtechsistemas.com.br).
* Connect with me on my linkedIn [Felipe Braiani](https://www.linkedin.com/in/felipe-gustavo-braiani-santos/)

[![BuyMeACoffee](https://img.shields.io/badge/Buy%20Me%20a%20Coffee-ffdd00?style=for-the-badge&logo=buy-me-a-coffee&logoColor=black)](https://www.buymeacoffee.com/felipebraiani)
[![Github-sponsors](https://img.shields.io/badge/sponsor-30363D?style=for-the-badge&logo=GitHub-Sponsors&logoColor=#EA4AAA)](https://github.com/sponsors/Braiani)