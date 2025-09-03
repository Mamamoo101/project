<?php
ini_set("display_errors",1);
ini_set("display_startup_errors",1);


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/products/{id}', function (Request $request, Response $response, $args) {
    $productID = $args['id'];
    $response->getBody()->write("Products Get Form ID :  $productID");
    return $response;
});



$app->get('/products', function (Request $request, Response $response, $args) {
    $connect = $GLOBALS['conn'];
    $sql = "select * From products";
    $result = $connect->query($sql);
    $data = array();
    while( $row = $result->fetch_assoc() ) {
        array_push($data, $row);
    }
    $json = json_encode( $data );
    $response->getBody()->write($json);
    return $response->withHeader('Content-type', 'appplication/json');
});



$app->get('/products/{products_code}', function (Request $request, Response $response, $args) {
    $pCode = $args['products_code'];
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("select * From products WHERE productCode = ?");
    $stmt->bind_param("s", $pCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while( $row = $result->fetch_assoc() ) {
        array_push($data, $row);
    }
    $json = json_encode( $data );
    $response->getBody()->write($json);
    return $response->withHeader('Content-type', 'application/json');
});



$app->get('/products/{productLine}/{productVendor}', function (Request $request, Response $response, array $args) {
    $pLine = $args['productLine'];
    $pVendor = $args['productVendor'];
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("select * From products WHERE productLine = ? and productVendor = ?");
    $stmt->bind_param("ss", $pLine, $pVendor);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = array();
    while( $row = $result->fetch_assoc() ) {
        array_push($data, $row);
    }
    $json = json_encode( $data );
    $response->getBody()->write($json);
    return $response->withHeader('Content-type', 'application/json');
});


$app->post('/products/textInsert', function (Request $request, Response $response, array $args) {
    $body = $request->getBody();
    $bodyArr = json_decode($body, true);
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("INSERT INTO products" . 
        "(productCode, productName, productLine, productScale, productVendor, ".
        "productDescription, quantityInStock, buyPrice, MSRP)".
        "VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssidd",
        $bodyArr['productCode'], $bodyArr['productName'], $bodyArr['productLine'],
        $bodyArr['productScale'], $bodyArr['productVendor'], $bodyArr['productDescription'],
        $bodyArr['quantityInStock'], $bodyArr['buyPrice'], $bodyArr['MSRP']
    );
    $stmt->execute();
    $result = $stmt->affected_rows;
    $response->getBody()->write($result."");
    return $response->withHeader('Content-type', 'application/json');
});


$app->post('/products/formInsert', function (Request $request, Response $response, array $args) {
    $body = $request->getParsedBody();
    $conn = $GLOBALS['conn'];
    $stmt = $conn->prepare("INSERT INTO products" . 
        "(productCode, productName, productLine, productScale, productVendor, ".
        "productDescription, quantityInStock, buyPrice, MSRP)".
        "VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssidd",
        $body['productCode'], $body['productName'], $body['productLine'],
        $body['productScale'], $body['productVendor'], $body['productDescription'],
        $body['quantityInStock'], $body['buyPrice'], $body['MSRP']);
    $stmt->execute();
    $result = $stmt->affected_rows;
    $response->getBody()->write($result."");
    return $response->withHeader('Content-type', 'application/json');
});