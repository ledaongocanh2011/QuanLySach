<?php

namespace App\Console;

use App\BookUserModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $giveBookBacks = BookUserModel::where('status', 0)->get();
            logger($giveBookBacks);
            foreach ($giveBookBacks as $item) {
                $userToExpire = $item['pay_day'];
                logger($userToExpire < Carbon::now() ? 'co' : 'khong');
                if ($userToExpire < Carbon::now()) {
                    $mess = "đã quá hạn trả sách " . $item->book->book_title . " rồi bạn eiiiii";
                    $user = $item->User;
                    $send = $item->sendToEmail;
                    if (User::CHUAGUI == $send) {
                        Mail::raw($mess, function ($mail) use ($user) {
                            $mail->from('admin@gmail.com');
                            $mail->to($user->email)->subject('everytime');
                        });
                        //sau khi gui mail se update lai trang thai gui ve da gui mail
                        $changeSend = $item->update([
                            'sendToEmail' => 1,
                        ]);
                    }
                    logger("sending to all user");
                }
            }
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
