<?php
require 'vendor/autoload.php';

MercadoPago\SDK::setAccessToken("SUA_ACCESS_TOKEN");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $metodo = $_POST['metodo_pagamento'];
    $total = floatval($_POST['total']);

    if ($metodo == "pix") {
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = $total;
        $payment->description = "Compra no Meu Marketplace";
        $payment->payment_method_id = "pix";
        $payment->payer = array("email" => $email);

        $payment->save();

        if ($payment->status == "approved") {
            echo "<h3 class='text-center text-success'>Pagamento aprovado via PIX!</h3>";
        } else {
            echo "<h3 class='text-center text-danger'>Erro no pagamento: " . $payment->status_detail . "</h3>";
        }
    } else {
        echo "<h3 class='text-center text-warning'>Método de pagamento ainda não implementado.</h3>";
    }
}
?>