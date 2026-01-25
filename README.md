Person api sample on php version 8.4 or later.

## About this package
Person model api sample with sanctum

- Read
  - GET:/api/people
  - GET:/api/person/{id}
- Create
  - POST:/api/person/store
- Update
  - POST:/api/person/{id}
- Delete
  - GET:/api/person/delete/{id}

```
herd coverage ./vendor/bin/pest --coverage
art test
```

## License

This utility is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
