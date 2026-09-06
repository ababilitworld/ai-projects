$ErrorActionPreference = 'Stop'
$client = [System.Net.Sockets.TcpClient]::new('www.dsebd.org', 443)
$stream = [System.Net.Security.SslStream]::new($client.GetStream(), $false)
try {
    $stream.AuthenticateAsClient('www.dsebd.org')
    $certificate = [System.Security.Cryptography.X509Certificates.X509Certificate2]::new($stream.RemoteCertificate)
    $chain = [System.Security.Cryptography.X509Certificates.X509Chain]::new()
    if (-not $chain.Build($certificate)) {throw 'DSE certificate did not validate using Windows trust.'}
    $pem = ''
    foreach ($element in $chain.ChainElements) {
        Write-Output "$($element.Certificate.Subject) | $($element.Certificate.Issuer)"
        if ($element.Certificate.Thumbprint -ne $certificate.Thumbprint) {
            $pem += $element.Certificate.ExportCertificatePem() + "`n"
        }
    }
    [System.IO.File]::WriteAllText((Join-Path $PSScriptRoot '../storage/dse-news-ca.pem'), $pem)
} finally {$stream.Dispose(); $client.Dispose()}
