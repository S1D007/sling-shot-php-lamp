<?php


set_time_limit(0);
ob_implicit_flush();

$address = '127.0.0.1';
$port = 8080;
$null = NULL;

// Create a TCP Stream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

// Bind the socket to an address/port
socket_bind($socket, $address, $port);

// Listen for incoming connections
socket_listen($socket);

$clients = array($socket);

function send_message($msg, $exclude_client = null) {
    global $clients, $socket;
    foreach ($clients as $client) {
        if ($client != $socket && $client != $exclude_client) {
            @socket_write($client, $msg, strlen($msg));
        }
    }
}

while (true) {
    $changed = $clients;
    socket_select($changed, $null, $null, 0, 10);
    
    if (in_array($socket, $changed)) {
        $socket_new = socket_accept($socket);
        $clients[] = $socket_new;

        $header = socket_read($socket_new, 1024);
        perform_handshaking($header, $socket_new, $address, $port);
        
        socket_getpeername($socket_new, $ip);
        $response = mask(json_encode(array('type' => 'system', 'message' => $ip.' connected')));
        send_message($response);

        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
    }
    
    foreach ($changed as $changed_socket) {
        while (socket_recv($changed_socket, $buf, 1024, 0) >= 1) {
            $received_text = unmask($buf);
            $msg = json_decode($received_text);
            
            if ($msg) {
                $alpha = $msg->alpha ?? null;
                $beta = $msg->beta ?? null;
                $gamma = $msg->gamma ?? null;
                $tracker = $msg->tracker ?? null;

                $response = mask(json_encode(array(
                    'alpha' => $alpha,
                    'beta' => $beta,
                    'gamma' => $gamma,
                    'tracker' => $tracker
                )));
                
                // Broadcast the message to all clients except the sender
                send_message($response, $changed_socket);
            }               
            break 2;
        }
        
        $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
        if ($buf === false) {
            $found_socket = array_search($changed_socket, $clients);
            unset($clients[$found_socket]);
        }
    }
}

socket_close($socket);

function perform_handshaking($receved_header, $client_conn, $host, $port) {
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach ($lines as $line) {
        $line = chop($line);
        if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey.'258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
               "Upgrade: websocket\r\n" .
               "Connection: Upgrade\r\n" .
               "WebSocket-Origin: $host\r\n" .
               "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n" .
               "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn, $upgrade, strlen($upgrade));
}

function unmask($text) {
    $length = ord($text[1]) & 127;
    if ($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    } elseif ($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    } else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }
    return $text;
}

function mask($text) {
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length >= 126 && $length <= 65535) {
        $header = pack('CCn', $b1, 126, $length);
    } elseif ($length > 65535) {
        $header = pack('CCNN', $b1, 127, $length);
    }
    return $header.$text;
}
?>
