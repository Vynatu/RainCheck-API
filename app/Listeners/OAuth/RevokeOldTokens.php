<?php

namespace RainCheck\Listeners\OAuth;

use Illuminate\Support\Carbon;
use Laravel\Passport\Client;
use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Token;

/**
 * Class RevokeOldTokens.
 * It is important that this class is executed in sync.
 * 3rd party clients can only have a single active token as a time.
 * It revokes the old access tokens of a single user, scoped by
 * user and client. Revoking does not delete any token. First-party
 * client tokens are left untouched.
 */
class RevokeOldTokens
{
    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated $event
     *
     * @return void
     */
    public function handle(AccessTokenCreated $event)
    {
        $client = Client::find($event->clientId);

        if (! $client || ! $client->firstParty()) {
            return;
        }

        Token::where(['user_id' => $event->userId, 'client_id' => $event->clientId, 'revoked' => false])
             ->where('expires_at', '>=', Carbon::now())
             ->whereNotIn('id', [$event->tokenId])
             ->update(['revoked' => true]);
    }
}
