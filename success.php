<!DOCTYPE html>
<html>
    <head>
        <title>Transaction Successful</title>
    </head>

    <body>
        <div style='text-align: center;'><h1>Transaction Successful</h1>

        <?php
            include_once 'config.php';

            error_reporting(0);
            ini_set('display_errors', 0);

            $tran_id  = $_POST['tran_id'];
            $val_id  = $_POST['val_id'];
            $amount   = $_POST['amount'];
            $currency = $_POST['currency'];

            if (!empty($val_id)) {
                $validationUrl = API_URL . "/validator/api/validationserverAPI.php";
                $data = [
                    'val_id' => $val_id,
                    'store_id' => STORE_ID,
                    'store_passwd' => STORE_PASSWD,
                    'format' => json,
                ];
                $queryString = http_build_query($data);

                $return = file_get_contents($validationUrl . "?" . $queryString);
                $content = json_decode($return);
                $status = $content->status;

                if (in_array($status, ['VALID', 'VALIDATED'])) {

                    echo "<h2 style='color: green;'>Congratulations! Your Transaction is Successful.</h2>";
                    ?>
                            <table border="1" class="table">
                                <thead>
                                <tr>
                                    <th colspan="2">Payment Status</th>
                                </tr>
                                </thead>
                                <tr>
                                    <td>Transaction ID</td>
                                    <td><?php echo $_POST['tran_id'] ?></td>
                                </tr>
                                <tr>
                                    <td>Card Type</td>
                                    <td><?php echo $_POST['card_type'] ?></td>
                                </tr>
                                <tr>
                                    <td>Bank Transaction ID</td>
                                    <td><?php echo $_POST['bank_tran_id'] ?></td>
                                </tr>
                                <tr>
                                    <td>Card Type</td>
                                    <td><?php echo $_POST['card_type'] ?></td>
                                </tr>
                                <tr>
                                    <td>Amount</td>
                                    <td><?php echo $_POST['currency_amount'] ?></td>
                                </tr>
                            </table>
                        </div>
                            <?php
                        // } else {
                        // }
            } else {
                echo "<h2 style='color: green; text-align: center;'>Congratulations! Your Transaction is Successful </h2>";
                echo "<span style='color: red;'>But validation failed.</span><h2> Transaction ID: " . $_POST['tran_id'] . "</h2>";

                if(DEBUG) {
                    echo '<pre>';
                    print_r($content);
                }
            }
        } else {

        }
            ?>
    </body>
</html>