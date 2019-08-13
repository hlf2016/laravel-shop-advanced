<?php

return [
    'alipay' => [
        'app_id'         => '2016092600600403',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvoFy2xwaTvWx7p7ns5wmLPoG0GUdB7aUAL6G/o7SOqy12FDUPjyXej9S+c2HM4BjmDsa2wkbf80bn0smZnvBizylWtBhG7na+TpnKWJFOmOHDKpapVeRvm9dkjdLmnGf1Qmz4CqZxSHcRP9DMYwUkRL+uynadarTPxS1u2xgVf6G2uo28ogP5BToW1AKaWF3yX6PK01YxQpih2IBaDm2ITjLnDKSzc3yF0u++A6IN3W2x2rdl3Pm4SkEurSjfCPz4+Xm1xZlOJDnuR5ZLQ4KqY8NwmXc8kyq6U36Obe9nJsZ2dq6xf2bn53zAncq79cm/RDhpY7JnKwY5SZ93LVskQIDAQAB',
        'private_key'    => 'MIIEpAIBAAKCAQEAuIbgVEfc/Xqc4/BK7a3BKXnlzezUqY0DHYrjewWluzdsTkgO2uPewmXZ9+XJlrFnRiEDXG35juzwFto+i8Rn5lrA473Vl9mKvEF7n39ZOfW4JCLzOu7osi/Tzd4T2uLDNSwf5N9VkdHGNqj+58seviMeUzuMJ62UwSLzcmpiWVBVDTKVm2E8ONSIhOy2M4Q4U6g3DUjm9SLGBbADdboo68XJfTVC+zNMX+dxluseZvj3RJDgFiKgyNtKrzurEuG2pq3Lozjmf7d0BptToibzeeNcpdjuOVCQkZbvP9CG8yf3+iXX9dbFsUb8ken/af/DQVauTen1lmTpgdkt31Mv+wIDAQABAoIBAEB+k8WhYHIP+uoIQIgWJN9URafV0PZ53M7kjmGfNa/bzTUHJnoHDwKvCqIEZJMQ6mGuhDg4D/OOiNPT7+x190KiEa0H2rG6TS1DTewPXKZPZc7rkEvW2On+oW7g4dutSkE5bORX0tamlTrhkkZ9zf7y01SQCYqMtuNSTfh9imZgfzI926h0lLPk+sEAevQwQoRfccr36MHZDTy2URVsuXsqWxuiLWJPS8xYo6M/fPxM41kAMAc+hQDB5cst+gAHttXuNgwt7MjyPefyzn+qL+PVd0uE+OkE+UBc7okecF+X7qrBOM5EX/zecCiLwg9JiTLgsWYqOfuHd7ZjrhYVKgECgYEA6Ilra32onV7x7hATfG6z0VY2+kdsuIOAUJhgGCchc9+34+ueYXAJ/GdFezJp2vUH1nSrCBrFt5AVGs2RQuV6Vya2JW4Nx9OwvhdWu/+YBNGprWg0TtZE+g8+z6l1+uPThZZOn1mI31+Bd92imwu1d/J84ytVfRmRn1yX25bAVoECgYEAyyVT/BEoE/5piVW4b3lFuKK3EFq6rbKjEosc2Lw2xaI35L3mQ8azOXG1sx0Zb01xMB/m0NAsHQUbrZnIkbrlhPGd4gpMFByrgQwSbc8IFhYSQ9PNY2TEhvWc0vadI9p8XXAz5frodmNQM9KoDwQPDiuJE5dlmK1ylH2ZEihZoHsCgYEAj/ltkgsmV/GON0iq1/Mu0KDhv0pzzTZWPxBpButLchQFJlAfKtMUy7shMOsA0Xm+1ZA8yPLSkhnah1LZ6qJsggNM6ZXfYGb4WmnW4OWauPkbZmtLX7iY0n6X9DlG/AUNVPvASDdGYI8geRe38uln/REdNAYDk0Y+fH325BXNloECgYBvhXyHoruHzmENndt0hvT5mYo6FjTpamoPogMiEKFY+ecJUh75EjoNzRjczZrK+Y6rxrel5sJw4/7/3K65IgsiYqo0D0cYu2yDmab8VW2xAkjgp4PXjtg85tVDE1PM/QLNIO280XOQmpDLAlh0ddv2AXxtHu4NVRrT3eeMik45xQKBgQCbfLn9BqPNpnWK4rfg0PVsMl/DR+U1N98nTHbGhJ2EW6kfm7ggvLS+I8O1ANB3zrkPJQ7nOXETWicIzF0m7lkazwbPuO5KHuqUV/6y6O6FQoXxDCegaFNb6fhFIOQYmyzGF3/KiRLOQnxEhxW7K3+85e8JPKo7z0Ib23dx7c8krA==',
        'log'            => [
            'file' => storage_path('logs/alipay.log'),
        ]
    ],
    'wechat' => [
        'app_id'      => '公众号 app id',
        'mch_id'      => '第一步获取到的商户号',
        // 密钥可以通过 http://www.unit-conversion.info/texttools/random-string-generator/ 生成
        // Length 那个框填入 32 然后点击 Generate 按钮，下方的 Output 就会出现一个 32 个字符的随机字符串，把这个字符串复制下来。
        'key'         => '刚刚设置的 API 密钥',
        'cert_client' => resource_path('wechat_pay/apiclient_cert.pem'),
        'cert_key'    => resource_path('wechat_pay/apiclient_key.pem'),
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log')
        ]
    ]
];
