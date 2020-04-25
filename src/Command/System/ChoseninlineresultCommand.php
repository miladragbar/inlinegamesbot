<?php
/**
 * Inline Games - Telegram Bot (@inlinegamesbot)
 *
 * (c) 2016-2020 Jack'lul <jacklulcat@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;

use Bot\Exception\BotException;
use Bot\Exception\StorageException;
use Bot\Exception\TelegramApiException;
use Bot\GameCore;
use Bot\Helper\Utilities;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Throwable;

/**
 * Handle event when inline message is pasted into chat, instantly put a player into game
 */
class ChoseninlineresultCommand extends SystemCommand
{
    /**
     * @return bool|ServerResponse
     *
     * @throws TelegramException
     * @throws BotException
     * @throws StorageException
     * @throws TelegramApiException
     * @throws Throwable
     */
    public function execute()
    {
        $chosen_inline_result = $this->getUpdate()->getChosenInlineResult();

        Utilities::debugPrint('Data: ' . $chosen_inline_result->getResultId());

        $game = new GameCore($chosen_inline_result->getInlineMessageId(), $chosen_inline_result->getResultId(), $this);

        if ($game->canRun()) {
            return $game->run();
        }

        return parent::execute();
    }
}
