# Fat Bear Week Tournament ![Yasashii Badge](./public/images/yasashii-badge.png)
This is a March Madness-style tournament for Fat Bear Week. Compete against your friends to see who can score the most fat bear points.

## Developing
This is PHP + an RDBMS. It's tested on Postgres, but there's no reason you can't use sqlite or something, I guess.

```sh
composer install
vi .env # configure the needfuls
php artisan migrate --seed

pnpm install
pnpm build
```
