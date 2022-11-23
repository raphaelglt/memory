<?php 
$messages = [
    [
        "message" => "test",
        "user" => "danaoda"
    ],
    [
        "message" => "tesededt",
        "user" => "danaodzdadda"
    ],
    [
        "message" => "tedkst",
        "user" => "danadajopaoda"
    ]
    ];
for ($index =0; $index<count($messages); $index++) {
    echo $messages[$index]['user']." ".$messages[$index]['message']."<br />";
}
foreach ($messages as $message) {
    echo $message['user']." ".$message['message']."<br />";
}
?>