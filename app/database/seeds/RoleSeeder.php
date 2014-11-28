<?php


use SC2CTL\DotCom\EloquentModels\Role;

class RoleSeeder extends Seeder
{

    public function run()
    {
        $refl = new ReflectionClass(Role::class);
        foreach ($refl->getConstants() as $name => $value) {

            // We don't want any of our non-integer constants here.
            if (!is_numeric($value)) {
                continue;
            }

            Role::create([
                'id' => $value,
                'name' => strtolower($name)
            ]);
        }
    }

} 