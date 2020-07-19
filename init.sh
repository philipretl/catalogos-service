
echo "🦊 Init Proyect \n"
echo "\n🦊  Migrating and seeding... \n"
APP_ENV=local php artisan migrate:fresh --seed
echo "\n🦊 ️ Migration finished\n"
rm storage/oauth-private.key || true
rm storage/oauth-public.key || true
php artisan passport:install
echo "\n🦊 ️ Copying oauth keys finished\n"
