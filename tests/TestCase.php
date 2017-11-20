<?php

namespace Tests;

use RainCheck\Models\User;
use RainCheck\Models\Address;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestResponse;
use RainCheck\Support\Contracts\Eloquent\HasUniqueToken;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user = null;

    /**
     * Set the current admin for the application with the given scopes.
     *
     * @param array $scopes
     *
     * @return \Tests\TestCase
     */
    public function loginAsAdmin($scopes = [])
    {
        return $this->logIn('admin', $scopes);
    }

    /**
     * Set the current user for the application with the given scopes.
     *
     * @param string $as user or admin
     * @param array $scopes
     *
     * @return \Tests\TestCase
     */
    public function logIn($as, $scopes = [])
    {
        $this->user = factory(User::class)->states($as)->create()->fresh();
        $this->user->addresses()->save(factory(Address::class)->make(['user_id' => null]));

        return $this->actingAs($this->user, $scopes);
    }

    /**
     * Set the current user for the application with the given scopes.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array $scopes
     *
     * @return $this
     */
    public function actingAs(UserContract $user, $scopes = [])
    {
        Passport::actingAs($user, $scopes);

        return $this;
    }

    /**
     * Set the current user for the application with the given scopes.
     *
     * @param array $scopes
     *
     * @return \Tests\TestCase
     */
    public function loginAsUser($scopes = [])
    {
        return $this->logIn('user', $scopes);
    }

    protected function setUp()
    {
        TestResponse::macro('assertUniqueToken', function (...$resource) {
            /*
             * @var TestResponse $this
             */
            if ($resource[0] instanceof HasUniqueToken) {
                return $this->assertJsonFragment(
                    ['id' => $resource[0]->getAttribute($resource[0]->getUniqueTokenColumn())]
                );
            }

            // Else, we'll assume they passed in a value, with optional argument the column
            if (is_string($value = $resource[0])) {
                $column = $resource[1] ?? 'id';

                return $this->assertJsonFragment(
                    [$column => $value]
                );
            }

            // No assertion
            return $this;
        });

        parent::setUp();
    }
}
