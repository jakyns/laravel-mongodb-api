# Laravel with MongoDB - API

Getting up and running
----------------------

## Requirements

- [VirtualBox](https://www.virtualbox.org/wiki/Downloads). Tested on 5.0.14, but 4.x.x should also work.
- [Vagrant](http://www.vagrantup.com/downloads.html). Tested on 1.8.1
- [Ansible](http://docs.ansible.com/intro_installation.html). Tested on 2.0.1.0
- [Laravel](https://laravel.com). Tested on 5.2.x

## Agreement
- [PSR](http://www.php-fig.org/psr/). We are following PSR coding standards.

## Setting up Development

### Configure Vagrant and VirtualBox
- `vagrant box add https://github.com/kraksoft/vagrant-box-ubuntu/releases/download/14.04/ubuntu-14.04-amd64.box --name ubuntu/trusty64` (we use Ubuntu 14.04 LTS for box)
- `vagrant plugin install vagrant-vbguest` (Optional: for fixing vb-guest issue)
- `vagrant up`
- `vagrant provision` (Optional: for re-provision if there are changes)

### Config Laravel
- add `127.0.0.1 laravel-mongodb-api` to `/etc/hosts`
- `chmod -R 777 /api/storage`
- Access API with http://laravel-mongodb-api:8080

### Testing
- `vagrant ssh` for shh to this server
- `composer dump-autoload` at `/vagrant/api`
- `./vendor/bin/phpunit tests` to run test
- (Optional: if you want to initial data, `php artisan db:seed` in `/vagrant/api`)

Deployment
------------

Run these commands in local:

    vagrant up

Document
------------

# Users
-------------

### This document contains the following subjects

## User
- [List all users](#list-all-users)
- [Retrieve a user](#retrieve-a-user)
- [Create a new user](#create-a-user)
- [Update user](#update-user)
- [Delete user](#delete-user)

## Customer
- [List all customers](#list-all-customers)
- [Retrieve a customer](#retrieve-a-customer)
- [Create a new customer](#create-a-customer)
- [Update customer](#update-customer)
- [Delete customer](#delete-customer)
- [Add features to customer](#add-features-to-customer)

## Feature
- [List all features](#list-all-features)
- [Retrieve a feature](#retrieve-a-feature)
- [Create a new feature](#create-a-feature)
- [Update feature](#update-feature)
- [Delete feature](#delete-feature)

### Attribute

| Name            | Type        | Description |
| --------------- | ----------- | ----------- |
| id              | object_id   | A `USER_ID` matching `/user?_[1-9a-z]+/`. |
| firstname       | string      | First name of the user. |
| lastname        | string      | Last name of the user. |
| email           | string      | Email of the user. |
| created_at      | datetime    | Creation date of the user. |
| updated_at      | datetime    | Update date of the user. |


### Json Response Example

```json
{
    "data": [
        {
            "id": "561789d9068dabe909bb958b",
            "firstname": "Nicolette",
            "lastname": "Robel",
            "email": "Wehner.Albert@example.net",
            "created_at": "2015-10-09 09:33:13",
            "updated_at": "2016-01-10 16:47:20"
        },
        {
            "id": "5617d669068dab3e0d535507",
            "firstname": "Monty",
            "lastname": "Wyman",
            "email": "mSawayn@example.com",
            "created_at": "2015-10-09 14:59:53",
            "updated_at": "2016-01-27 16:06:50"
        }
    ],
    "meta": {
        "pagination": {
            "total": 2,
            "count": 2,
            "per_page": 20,
            "current_page": 1,
            "total_pages": 1,
            "links": []
        }
    }
}
```

---

## List all users
### Request URL
**GET** `/api/users`

### Query Parameter
| Name        | Type     | Description |
| ----------- | -------- | ----------- |
| limit       | integer  | (optional, default: 20, maximum: 100) The maximum amount of records returned. |
| from        | datetime | (optional, default: `2015-01-01`) The date and time limiting the beginning of returned records. E.g.: `2016-04-25 00:00:00` |
| to          | datetime | (optional, default: current Datetime) The date and time limiting the end of returned records. E.g.: `2016-04-26 00:00:00` |
| order       | string   | (optional, default: desc) The order of the list returned. I.e.: `desc` (from earliest to latest), `asc` (from latest to earliest). |

---

## Retrieve a user
### Request URL
**GET** `/api/users/USER_ID`

---

## Create a new user
### Request URL
**POST** `/api/users`

### Request Parameter
| Name                             | Type       | Description |
| ---------------------            | ---------- | ----------- |
| firstname (maximum: 255)         | string     | (required) Firstname of the user. |
| lastname (maximum: 255)          | string     | (required) Lastname of the user. |
| email (maximum: 255, unique)     | string     | (required) Email of the user. |
| pasword                          | string     | (required) Password of ths user. |
| password_confirmation            | string     | (required) Must be same as the `password`. |
| country (minimum: 2, maximum: 5) | string     | (required) Country code of the user. |

---

## Update a user
### Request URL
**PATCH** `/api/users/USER_ID`

### Request Parameter
| Name                             | Type       | Description |
| -------------------------------- | ---------- | ----------- |
| firstname (maximum: 255)         | string     | (required) Firstname of the user. |
| lastname (maximum: 255)          | string     | (required) Lastname of the user. |
| email (maximum: 255, unique)     | string     | (required) Email of the user. |
| pasword                          | string     | (required) Password of ths user. |
| password_confirmation            | string     | (required) Must be same as the `password`. |
| country (minimum: 2, maximum: 5) | string     | (required) Country code of the user. |

---

## Delete a user
### Request URL
**DELETE** `/api/users/USER_ID`

---

# Customers
-------------

### Attribute

| Name          | Type       | Description |
| ------------- | ---------- | ----------- |
| id            | object_id  | A `CUSTOMER_ID` matching `/customer?_[1-9a-z]+/`. |
| name          | string     | name of the customer. |
| description   | string     | description of the customer. |
| email         | string     | Email of the customer. |
| created_at    | datetime   | Creation date of the customer. |
| updated_at    | datetime   | Update date of the customer. |
| features      | list       | List of feature associate with customer. |


### Json Response Example

```json
{
    "data": [
        {
            "id": "57271f6dd199ae0678232863",
            "name": "Rebeka Champlin",
            "description": "Alias magni similique porro quo quisquam quia eaque.",
            "email": "hblock@example.org",
            "created_at": "2015-10-09 09:33:13",
            "updated_at": "2016-01-10 16:47:20",
            "features": []
        },
        {
            "id": "57271f6dd199ae0678232864",
            "name": "Kaleb Funk MD",
            "description": "Voluptates dolor facere sapiente est explicabo voluptatibus error. ",
            "email": "trystan97@example.net",
            "created_at": "2015-10-09 14:59:53",
            "updated_at": "2016-01-27 16:06:50",
            "features": []
        }
    ],
    "meta": {
        "pagination": {
            "total": 2,
            "count": 2,
            "per_page": 20,
            "current_page": 1,
            "total_pages": 1,
            "links": []
        }
    }
}
```

---

## List all customers
### Request URL
**GET** `/api/customers`

### Query Parameter
| Name        | Type     | Description |
| ----------- | -------- | ----------- |
| limit       | integer  | (optional, default: 20, maximum: 100) The maximum amount of records returned. |
| from        | datetime | (optional, default: `2015-01-01`) The date and time limiting the beginning of returned records. E.g.: `2016-04-25 00:00:00` |
| to          | datetime | (optional, default: current Datetime) The date and time limiting the end of returned records. E.g.: `2016-04-26 00:00:00` |
| order       | string   | (optional, default: desc) The order of the list returned. I.e.: `desc` (from earliest to latest), `asc` (from latest to earliest). |

---

## Retrieve a customer
### Request URL
**GET** `/api/customers/CUSTOMER_ID`

---

## Create a new customer
### Request URL
**POST** `/api/customers`

### Request Parameter
| Name                         | Type       | Description |
| ---------------------------- | ---------- | ----------- |
| name (maximum: 255, unique)  | string     | (required) Name of the customer. |
| description                  | string     | (required) Description of the customer. |
| email (maximum: 255, unique) | string     | (required) Email of the customer. |

---

## Update a customer
### Request URL
**PATCH** `/api/customers/CUSTOMER_ID`

### Request Parameter
| Name                         | Type       | Description |
| ---------------------------- | ---------- | ----------- |
| name (maximum: 255, unique)  | string     | (required) Name of the customer. |
| description                  | string     | (required) Description of the customer. |
| email (maximum: 255, unique) | string     | (required) Email of the customer. |

---

## Delete a customer
### Request URL
**DELETE** `/api/customers/CUSTOMER_ID`

---

## Add features to customer
### Request URL
**POST** `/api/customers/CUSTOMER_ID/features`

| Name                         | Type       | Description |
| ---------------------------- | ---------- | ----------- |
| features_id                  | array      | (required) Array of feature to add to customer. |

---

# Features
-------------

### Attribute

| Name          | Type       | Description |
| ------------- | ---------- | ----------- |
| id            | object_id  | A `FEATURE_ID` matching `/feature?_[1-9a-z]+/`. |
| name          | string     | Name of the feature. |
| display_name  | string     | Display name of the feature. |
| description   | string     | Description of the feature. |
| created_at    | datetime   | Creation date of the feature. |
| updated_at    | datetime   | Update date of the feature. |


### Json Response Example

```json
{
    "data": [
        {
            "id": "57271f6dd199ae067823286d",
            "name": "Deangelo Kassulke",
            "display_name": "Dr. Dalton Lebsack Jr.",
            "description": "Atque ipsum quod fuga vel aut. ",
            "created_at": "2016-05-02 09:35:41",
            "updated_at": "2016-05-02 09:35:41"
        },
        {
            "id": "57271f6dd199ae067823286e",
            "name": "Kailyn Pagac V",
            "display_name": "Diamond Emmerich",
            "description": "Occaecati distinctio eius dignissimos porro est.",
            "created_at": "2016-05-02 09:35:41",
            "updated_at": "2016-05-02 09:35:41"
        }
    ],
    "meta": {
        "pagination": {
            "total": 2,
            "count": 2,
            "per_page": 20,
            "current_page": 1,
            "total_pages": 1,
            "links": []
        }
    }
}
```

---

## List all features
### Request URL
**GET** `/api/features`

### Query Parameter
| Name        | Type     | Description |
| ----------- | -------- | ----------- |
| limit       | integer  | (optional, default: 20, maximum: 100) The maximum amount of records returned. |
| from        | datetime | (optional, default: `2015-01-01`) The date and time limiting the beginning of returned records. E.g.: `2016-04-25 00:00:00` |
| to          | datetime | (optional, default: current Datetime) The date and time limiting the end of returned records. E.g.: `2016-04-26 00:00:00` |
| order       | string   | (optional, default: desc) The order of the list returned. I.e.: `desc` (from earliest to latest), `asc` (from latest to earliest). |

---

## Retrieve a feature
### Request URL
**GET** `/api/features/FEATURE_ID`

---

## Create a new feature
### Request URL
**POST** `/api/features`

### Request Parameter
| Name                         | Type       | Description |
| ---------------------------- | ---------- | ----------- |
| name (maximum: 255, unique)  | string     | (required) Name of the feature. |
| display_name (maximum: 255)  | string     | (required) Display name of the feature. |
| description                  | string     | (required) Description of the feature. |

---

## Update a feature
### Request URL
**PATCH** `/api/features/FEATURE_ID`

### Request Parameter
| Name                         | Type       | Description |
| ---------------------------- | ---------- | ----------- |
| name (maximum: 255, unique)  | string     | (required) Name of the feature. |
| display_name (maximum: 255)  | string     | (required) Display name of the feature. |
| description                  | string     | (required) Description of the feature. |

---

## Delete a feature
### Request URL
**DELETE** `/api/features/FEATURE_ID`

---
