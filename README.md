## Getting started

To start the application for testing, you can run ```docker-compose up``` to launch the database. Then, using the Symfony CLI, you can start the development server.
```symfony server:start```

## Endpoints examples

To test the API, you can use curl:

Register new employee

```curl -X POST 127.0.0.1:8000/api/v1/employees -H "Content-Type: application/json" -d '{"first_name_and_last_name":"Jan Kowaslki"}```

Register new worktimes period

```curl -X POST 127.0.0.1:{port}/api/v1/employees/{uuid}/worktimes -H "Content-Type: application/json" -d '{"start_date_time":"02.01.1977 07:40", "end_date_time":"02.01.1977 14:00"}'```

Summarise 

```curl -X GET 127.0.0.1:{port}/api/v1/employees/{uuid}/worktimes/{start_period}/summarise```

## Requirements

```PHP >= 8.3```

```MySQL 8.0.37```

```Symfony 7.1.*```
