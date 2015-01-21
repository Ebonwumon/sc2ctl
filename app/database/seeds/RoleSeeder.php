<?php


use SC2CTL\DotCom\EloquentModels\Role;

class RoleSeeder extends Seeder
{

    public function run()
    {
        $refl = new ReflectionClass(Role::class);
        foreach ($refl->getConstants() as $name => $value) {

            if (strpos($name, "ROLE_") !== 0) {
                continue;
            }

            Role::create([
                'id' => $value,
            ]);
        }
    }

} 
