@{
  ModuleVersion = '1.0.0.0'
  GUID = '{6B7205CC-1C9A-4B28-AD1A-8DFA48027C3E}'
  PowerShellVersion = '3.0'
  DotNetFrameworkVersion = ''
  CLRVersion = '4.0'
  Author = 'VisualSVN Software Ltd.'
  CompanyName = 'VisualSVN Software Ltd.'
  Copyright = '© VisualSVN Software Ltd. All rights reserved.'
  Description = 'PowerShell module to manage VisualSVN Server'

  NestedModules = @(
    "SvnRepository.cdxml",
    "SvnRepositoryItem.cdxml",
    "SvnRepositoryHook.cdxml",
    "SvnAccessRule.cdxml",
    "SvnServerConfiguration.cdxml",
    "SvnJob.cdxml",
    "SvnReplicationAuthentication.cdxml",
    "SvnServerCertificateRequest.cdxml",
    "SvnServerLicense.cdxml"
  )

  TypesToProcess = @(
    "SvnRepository.Types.ps1xml",
    "SvnRepositoryReplication.Types.ps1xml",
    "SvnRepositoryTestResult.Types.ps1xml",
    "SvnRepositoryItem.Types.ps1xml",
    "SvnRepositoryHook.Types.ps1xml",
    "SvnAccessRule.Types.ps1xml",
    "SvnServerConfiguration.Types.ps1xml",
    "SvnExternalRepository.Types.ps1xml",
    "SvnJob.Types.ps1xml",
    "SvnReplicationAuthentication.Types.ps1xml",
    "SvnServerLicense.Types.ps1xml",
    "SvnJobRunResult.Types.ps1xml"
  )

  FormatsToProcess = @(
    "SvnRepository.Format.ps1xml",
    "SvnRepositoryReplication.Format.ps1xml",
    "SvnRepositoryTestResult.Format.ps1xml",
    "SvnRepositoryItem.Format.ps1xml",
    "SvnRepositoryStats.Format.ps1xml",
    "SvnRepositoryHook.Format.ps1xml",
    "SvnRepositoryBackup.Format.ps1xml",
    "SvnAccessRule.Format.ps1xml",
    "SvnServerConfiguration.Format.ps1xml",
    "SvnExternalRepository.Format.ps1xml",
    "SvnJob.Format.ps1xml",
    "SvnReplicationAuthentication.Format.ps1xml",
    "SvnRepositoryDumpFile.Format.ps1xml",
    "SvnServerLicense.Format.ps1xml",
    "SvnJobRunResult.Format.ps1xml"
  )

  FunctionsToExport = @(
    "New-SvnRepository",
    "Get-SvnRepository",
    "Remove-SvnRepository",
    "Rename-SvnRepository",
    "Test-SvnRepository",
    "Convert-SvnRepository",
    "Sync-SvnRepository",
    "Set-SvnRepository",
    "Suspend-SvnRepository",
    "Resume-SvnRepository",
    "Switch-SvnRepository",
    "Import-SvnRepository",
    "Measure-SvnRepository",
    "Backup-SvnRepository",
    "Restore-SvnRepository",
    "Update-SvnRepository",
    "Export-SvnRepository",
    "Get-SvnRepositoryReplication",
    "Set-SvnRepositoryReplication",
    "Get-SvnRepositoryItem",
    "New-SvnRepositoryItem",
    "Remove-SvnRepositoryItem",
    "Get-SvnRepositoryHook",
    "Set-SvnRepositoryHook",
    "Add-SvnRepositoryHook",
    "Remove-SvnRepositoryHook",
    "Get-SvnAccessRule",
    "Set-SvnAccessRule",
    "Add-SvnAccessRule",
    "Remove-SvnAccessRule",
    "Select-SvnAccessRule",
    "Get-SvnServerConfiguration",
    "Set-SvnServerConfiguration",
    "Get-SvnJob",
    "Start-SvnJob",
    "Stop-SvnJob",
    "Enable-SvnJob",
    "Disable-SvnJob",
    "New-SvnReplicationAuthentication",
    "New-SvnServerCertificateRequest",
    "Get-SvnServerLicense",
    "Set-SvnServerLicense",
    "Invoke-SvnJob"
  )

  CmdletsToExport = @(
  )

  AliasesToExport = @(
    "Verify-SvnRepository",
    "Upgrade-SvnRepository"
  )
}

# SIG # Begin signature block
# MIIaOQYJKoZIhvcNAQcCoIIaKjCCGiYCAQExCzAJBgUrDgMCGgUAMGkGCisGAQQB
# gjcCAQSgWzBZMDQGCisGAQQBgjcCAR4wJgIDAQAABBAfzDtgWUsITrck0sYpfvNR
# AgEAAgEAAgEAAgEAAgEAMCEwCQYFKw4DAhoFAAQUSZ2MqP11G2XgvipyjpIcxteR
# KEygghVVMIID7jCCA1egAwIBAgIQfpPr+3zGTlnqS5p31Ab8OzANBgkqhkiG9w0B
# AQUFADCBizELMAkGA1UEBhMCWkExFTATBgNVBAgTDFdlc3Rlcm4gQ2FwZTEUMBIG
# A1UEBxMLRHVyYmFudmlsbGUxDzANBgNVBAoTBlRoYXd0ZTEdMBsGA1UECxMUVGhh
# d3RlIENlcnRpZmljYXRpb24xHzAdBgNVBAMTFlRoYXd0ZSBUaW1lc3RhbXBpbmcg
# Q0EwHhcNMTIxMjIxMDAwMDAwWhcNMjAxMjMwMjM1OTU5WjBeMQswCQYDVQQGEwJV
# UzEdMBsGA1UEChMUU3ltYW50ZWMgQ29ycG9yYXRpb24xMDAuBgNVBAMTJ1N5bWFu
# dGVjIFRpbWUgU3RhbXBpbmcgU2VydmljZXMgQ0EgLSBHMjCCASIwDQYJKoZIhvcN
# AQEBBQADggEPADCCAQoCggEBALGss0lUS5ccEgrYJXmRIlcqb9y4JsRDc2vCvy5Q
# WvsUwnaOQwElQ7Sh4kX06Ld7w3TMIte0lAAC903tv7S3RCRrzV9FO9FEzkMScxeC
# i2m0K8uZHqxyGyZNcR+xMd37UWECU6aq9UksBXhFpS+JzueZ5/6M4lc/PcaS3Er4
# ezPkeQr78HWIQZz/xQNRmarXbJ+TaYdlKYOFwmAUxMjJOxTawIHwHw103pIiq8r3
# +3R8J+b3Sht/p8OeLa6K6qbmqicWfWH3mHERvOJQoUvlXfrlDqcsn6plINPYlujI
# fKVOSET/GeJEB5IL12iEgF1qeGRFzWBGflTBE3zFefHJwXECAwEAAaOB+jCB9zAd
# BgNVHQ4EFgQUX5r1blzMzHSa1N197z/b7EyALt0wMgYIKwYBBQUHAQEEJjAkMCIG
# CCsGAQUFBzABhhZodHRwOi8vb2NzcC50aGF3dGUuY29tMBIGA1UdEwEB/wQIMAYB
# Af8CAQAwPwYDVR0fBDgwNjA0oDKgMIYuaHR0cDovL2NybC50aGF3dGUuY29tL1Ro
# YXd0ZVRpbWVzdGFtcGluZ0NBLmNybDATBgNVHSUEDDAKBggrBgEFBQcDCDAOBgNV
# HQ8BAf8EBAMCAQYwKAYDVR0RBCEwH6QdMBsxGTAXBgNVBAMTEFRpbWVTdGFtcC0y
# MDQ4LTEwDQYJKoZIhvcNAQEFBQADgYEAAwmbj3nvf1kwqu9otfrjCR27T4IGXTdf
# plKfFo3qHJIJRG71betYfDDo+WmNI3MLEm9Hqa45EfgqsZuwGsOO61mWAK3ODE2y
# 0DGmCFwqevzieh1XTKhlGOl5QGIllm7HxzdqgyEIjkHq3dlXPx13SYcqFgZepjhq
# IhKjURmDfrYwggSjMIIDi6ADAgECAhAOz/Q4yP6/NW4E2GqYGxpQMA0GCSqGSIb3
# DQEBBQUAMF4xCzAJBgNVBAYTAlVTMR0wGwYDVQQKExRTeW1hbnRlYyBDb3Jwb3Jh
# dGlvbjEwMC4GA1UEAxMnU3ltYW50ZWMgVGltZSBTdGFtcGluZyBTZXJ2aWNlcyBD
# QSAtIEcyMB4XDTEyMTAxODAwMDAwMFoXDTIwMTIyOTIzNTk1OVowYjELMAkGA1UE
# BhMCVVMxHTAbBgNVBAoTFFN5bWFudGVjIENvcnBvcmF0aW9uMTQwMgYDVQQDEytT
# eW1hbnRlYyBUaW1lIFN0YW1waW5nIFNlcnZpY2VzIFNpZ25lciAtIEc0MIIBIjAN
# BgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAomMLOUS4uyOnREm7Dv+h8GEKU5Ow
# mNutLA9KxW7/hjxTVQ8VzgQ/K/2plpbZvmF5C1vJTIZ25eBDSyKV7sIrQ8Gf2Gi0
# jkBP7oU4uRHFI/JkWPAVMm9OV6GuiKQC1yoezUvh3WPVF4kyW7BemVqonShQDhfu
# ltthO0VRHc8SVguSR/yrrvZmPUescHLnkudfzRC5xINklBm9JYDh6NIipdC6Anqh
# d5NbZcPuF3S8QYYq3AhMjJKMkS2ed0QfaNaodHfbDlsyi1aLM73ZY8hJnTrFxeoz
# C9Lxoxv0i77Zs1eLO94Ep3oisiSuLsdwxb5OgyYI+wu9qU+ZCOEQKHKqzQIDAQAB
# o4IBVzCCAVMwDAYDVR0TAQH/BAIwADAWBgNVHSUBAf8EDDAKBggrBgEFBQcDCDAO
# BgNVHQ8BAf8EBAMCB4AwcwYIKwYBBQUHAQEEZzBlMCoGCCsGAQUFBzABhh5odHRw
# Oi8vdHMtb2NzcC53cy5zeW1hbnRlYy5jb20wNwYIKwYBBQUHMAKGK2h0dHA6Ly90
# cy1haWEud3Muc3ltYW50ZWMuY29tL3Rzcy1jYS1nMi5jZXIwPAYDVR0fBDUwMzAx
# oC+gLYYraHR0cDovL3RzLWNybC53cy5zeW1hbnRlYy5jb20vdHNzLWNhLWcyLmNy
# bDAoBgNVHREEITAfpB0wGzEZMBcGA1UEAxMQVGltZVN0YW1wLTIwNDgtMjAdBgNV
# HQ4EFgQURsZpow5KFB7VTNpSYxc/Xja8DeYwHwYDVR0jBBgwFoAUX5r1blzMzHSa
# 1N197z/b7EyALt0wDQYJKoZIhvcNAQEFBQADggEBAHg7tJEqAEzwj2IwN3ijhCcH
# bxiy3iXcoNSUA6qGTiWfmkADHN3O43nLIWgG2rYytG2/9CwmYzPkSWRtDebDZw73
# BaQ1bHyJFsbpst+y6d0gxnEPzZV03LZc3r03H0N45ni1zSgEIKOq8UvEiCmRDoDR
# EfzdXHZuT14ORUZBbg2w6jiasTraCXEQ/Bx5tIB7rGn0/Zy2DBYr8X9bCT2bW+IW
# yhOBbQAuOA2oKY8s4bL0WqkBrxWcLC9JG9siu8P+eJRRw4axgohd8D20UaF5Mysu
# e7ncIAkTcetqGVvP6KUwVyyJST+5z3/Jvz4iaGNTmr1pdKzFHTx/kuDDvBzYBHUw
# ggX4MIIE4KADAgECAhAKVN5IMVmt95OAQJbHAYr+MA0GCSqGSIb3DQEBCwUAMGwx
# CzAJBgNVBAYTAlVTMRUwEwYDVQQKEwxEaWdpQ2VydCBJbmMxGTAXBgNVBAsTEHd3
# dy5kaWdpY2VydC5jb20xKzApBgNVBAMTIkRpZ2lDZXJ0IEVWIENvZGUgU2lnbmlu
# ZyBDQSAoU0hBMikwHhcNMTcwNTExMDAwMDAwWhcNMjAwNTE1MTIwMDAwWjCCARIx
# HTAbBgNVBA8MFFByaXZhdGUgT3JnYW5pemF0aW9uMRMwEQYLKwYBBAGCNzwCAQMT
# AkNZMRQwEgYDVQQFDAvOl86VIDM1OTIwMDEzMDEGA1UECRMqQ0VOVFJPIElNUEVS
# SU8sIDJuZCBmbG9vciwgRmxhdC9PZmZpY2UgMjAxMR4wHAYDVQQJExVHcmlnb3Jp
# IEFmeGVudGlvdSwgMTExDTALBgNVBBETBDQwMDMxCzAJBgNVBAYTAkNZMREwDwYD
# VQQHEwhMaW1hc3NvbDEgMB4GA1UEChMXVmlzdWFsU1ZOIFNvZnR3YXJlIEx0ZC4x
# IDAeBgNVBAMTF1Zpc3VhbFNWTiBTb2Z0d2FyZSBMdGQuMIIBIjANBgkqhkiG9w0B
# AQEFAAOCAQ8AMIIBCgKCAQEAyn3ep0eT/O9JtTlviHMKquMDr2/Vdu3b7zRi0fQF
# uXLgGOETEv6bOshxMzcLqxETM92ut1EhjMbgAPWQ02WPR6Qb33EGmOzGypazypNZ
# sTRkxKcLGwB1rieMxz+9tgpNcjiG+PZHsTzhAmPMVCyGaQDKyGHa4f5GZ4NMLAs9
# OsLEyYRltq8Gy4N/qH5VUs6UZfgMxk7sI1PBQ33L8BbZoW1RGnxGmNTCGlNMrxud
# Z64Ee4DxULwXsBYeuiL74JyETEzPoJ4vvLlrD/7J483u6IvhsrtrO1kDRrTq4NVG
# ltPrsP5SfsNc4bUoDTZuE7IwWTKlrGoj87pDrF5TAVlsXQIDAQABo4IB7DCCAegw
# HwYDVR0jBBgwFoAUj+h+8G0yagAFI8dwl2o6kP9r6tQwHQYDVR0OBBYEFHnJO4t/
# nRKZZza4+HJI78a8mUxSMCkGA1UdEQQiMCCgHgYIKwYBBQUHCAOgEjAQDA5DWS3O
# l86VIDM1OTIwMDAOBgNVHQ8BAf8EBAMCB4AwEwYDVR0lBAwwCgYIKwYBBQUHAwMw
# ewYDVR0fBHQwcjA3oDWgM4YxaHR0cDovL2NybDMuZGlnaWNlcnQuY29tL0VWQ29k
# ZVNpZ25pbmdTSEEyLWcxLmNybDA3oDWgM4YxaHR0cDovL2NybDQuZGlnaWNlcnQu
# Y29tL0VWQ29kZVNpZ25pbmdTSEEyLWcxLmNybDBLBgNVHSAERDBCMDcGCWCGSAGG
# /WwDAjAqMCgGCCsGAQUFBwIBFhxodHRwczovL3d3dy5kaWdpY2VydC5jb20vQ1BT
# MAcGBWeBDAEDMH4GCCsGAQUFBwEBBHIwcDAkBggrBgEFBQcwAYYYaHR0cDovL29j
# c3AuZGlnaWNlcnQuY29tMEgGCCsGAQUFBzAChjxodHRwOi8vY2FjZXJ0cy5kaWdp
# Y2VydC5jb20vRGlnaUNlcnRFVkNvZGVTaWduaW5nQ0EtU0hBMi5jcnQwDAYDVR0T
# AQH/BAIwADANBgkqhkiG9w0BAQsFAAOCAQEAW/YhGMDqpM6hlQoNSNexbuWNH52q
# OM/w+ZSvgRBqGMOZ0OOMu4KNHiSRmiDcnFd5Q7c3KM1rhJB9uvS+0BI+LCxYqaD9
# Rn1GupveyyWGYvZhY/6Yjq2P3pxGxR0SIUws05Shfi/s8cDS0pe3cVVdmBomF7wc
# XP7dNcDuXPFc0gDJK1CH/93T3IpthIkK+Epa8BceOwqAz3a694UCUbmCxva8Wztb
# sASQauU52KVh5PMsQAMmRPO3hvfN+EiSnm84xuHaGunugRUM5cl2Em14+ioqJGNw
# UXQZVlGRBHT6hJJ9uhJ9M9kLKxAR0WpkP9iBuP/XVONTRxVthhqf1Wx25DCCBrww
# ggWkoAMCAQICEAPxtOFfOoLxFJZ4s9fYR1wwDQYJKoZIhvcNAQELBQAwbDELMAkG
# A1UEBhMCVVMxFTATBgNVBAoTDERpZ2lDZXJ0IEluYzEZMBcGA1UECxMQd3d3LmRp
# Z2ljZXJ0LmNvbTErMCkGA1UEAxMiRGlnaUNlcnQgSGlnaCBBc3N1cmFuY2UgRVYg
# Um9vdCBDQTAeFw0xMjA0MTgxMjAwMDBaFw0yNzA0MTgxMjAwMDBaMGwxCzAJBgNV
# BAYTAlVTMRUwEwYDVQQKEwxEaWdpQ2VydCBJbmMxGTAXBgNVBAsTEHd3dy5kaWdp
# Y2VydC5jb20xKzApBgNVBAMTIkRpZ2lDZXJ0IEVWIENvZGUgU2lnbmluZyBDQSAo
# U0hBMikwggEiMA0GCSqGSIb3DQEBAQUAA4IBDwAwggEKAoIBAQCnU/oPsrUT8WTP
# hID8roA10bbXx6MsrBosrPGErDo1EjqSkbpX5MTJ8y+oSDy31m7clyK6UXlhr0Mv
# DbebtEkxrkRYPqShlqeHTyN+w2xlJJBVPqHKI3zFQunEemJFm33eY3TLnmMl+ISa
# mq1FT659H8gTy3WbyeHhivgLDJj0yj7QRap6HqVYkzY0visuKzFYZrQyEJ+d8FKh
# 7+g+03byQFrc+mo9G0utdrCMXO42uoPqMKhM3vELKlhBiK4AiasD0RaCICJ2615U
# OBJi4dJwJNvtH3DSZAmALeK2nc4f8rsh82zb2LMZe4pQn+/sNgpcmrdK0wigOXn9
# 3b89OgklAgMBAAGjggNYMIIDVDASBgNVHRMBAf8ECDAGAQH/AgEAMA4GA1UdDwEB
# /wQEAwIBhjATBgNVHSUEDDAKBggrBgEFBQcDAzB/BggrBgEFBQcBAQRzMHEwJAYI
# KwYBBQUHMAGGGGh0dHA6Ly9vY3NwLmRpZ2ljZXJ0LmNvbTBJBggrBgEFBQcwAoY9
# aHR0cDovL2NhY2VydHMuZGlnaWNlcnQuY29tL0RpZ2lDZXJ0SGlnaEFzc3VyYW5j
# ZUVWUm9vdENBLmNydDCBjwYDVR0fBIGHMIGEMECgPqA8hjpodHRwOi8vY3JsMy5k
# aWdpY2VydC5jb20vRGlnaUNlcnRIaWdoQXNzdXJhbmNlRVZSb290Q0EuY3JsMECg
# PqA8hjpodHRwOi8vY3JsNC5kaWdpY2VydC5jb20vRGlnaUNlcnRIaWdoQXNzdXJh
# bmNlRVZSb290Q0EuY3JsMIIBxAYDVR0gBIIBuzCCAbcwggGzBglghkgBhv1sAwIw
# ggGkMDoGCCsGAQUFBwIBFi5odHRwOi8vd3d3LmRpZ2ljZXJ0LmNvbS9zc2wtY3Bz
# LXJlcG9zaXRvcnkuaHRtMIIBZAYIKwYBBQUHAgIwggFWHoIBUgBBAG4AeQAgAHUA
# cwBlACAAbwBmACAAdABoAGkAcwAgAEMAZQByAHQAaQBmAGkAYwBhAHQAZQAgAGMA
# bwBuAHMAdABpAHQAdQB0AGUAcwAgAGEAYwBjAGUAcAB0AGEAbgBjAGUAIABvAGYA
# IAB0AGgAZQAgAEQAaQBnAGkAQwBlAHIAdAAgAEMAUAAvAEMAUABTACAAYQBuAGQA
# IAB0AGgAZQAgAFIAZQBsAHkAaQBuAGcAIABQAGEAcgB0AHkAIABBAGcAcgBlAGUA
# bQBlAG4AdAAgAHcAaABpAGMAaAAgAGwAaQBtAGkAdAAgAGwAaQBhAGIAaQBsAGkA
# dAB5ACAAYQBuAGQAIABhAHIAZQAgAGkAbgBjAG8AcgBwAG8AcgBhAHQAZQBkACAA
# aABlAHIAZQBpAG4AIABiAHkAIAByAGUAZgBlAHIAZQBuAGMAZQAuMB0GA1UdDgQW
# BBSP6H7wbTJqAAUjx3CXajqQ/2vq1DAfBgNVHSMEGDAWgBSxPsNpA/i/RwHUmCYa
# CALvY2QrwzANBgkqhkiG9w0BAQsFAAOCAQEAGTNKDIEzN9utNsnkyTq7tRsueqLi
# 9ENCF56/TqFN4bHb6YHdnwHy5IjV6f4J/SHB7F2A0vDWwUPC/ncr2/nXkTPObNWy
# GTvmLtbJk0+IQI7N4fV+8Q/GWVZy6OtqQb0c1UbVfEnKZjgVwb/gkXB3h9zJjTHJ
# DCmiM+2N4ofNiY0/G//V4BqXi3zabfuoxrI6Zmt7AbPN2KY07BIBq5VYpcRTV6hg
# 5ucCEqC5I2SiTbt8gSVkIb7P7kIYQ5e7pTcGr03/JqVNYUvsRkG4Zc64eZ4IlguB
# jIo7j8eZjKMqbphtXmHGlreKuWEtk7jrDgRD1/X+pvBi1JlqpcHB8GSUgDGCBE4w
# ggRKAgEBMIGAMGwxCzAJBgNVBAYTAlVTMRUwEwYDVQQKEwxEaWdpQ2VydCBJbmMx
# GTAXBgNVBAsTEHd3dy5kaWdpY2VydC5jb20xKzApBgNVBAMTIkRpZ2lDZXJ0IEVW
# IENvZGUgU2lnbmluZyBDQSAoU0hBMikCEApU3kgxWa33k4BAlscBiv4wCQYFKw4D
# AhoFAKCBlDAZBgkqhkiG9w0BCQMxDAYKKwYBBAGCNwIBBDAcBgorBgEEAYI3AgEL
# MQ4wDAYKKwYBBAGCNwIBFTAjBgkqhkiG9w0BCQQxFgQUNPgFQ4uPpibaR3ysd0Xz
# yaMCCY8wNAYKKwYBBAGCNwIBDDEmMCSgIoAgAFYAaQBzAHUAYQBsAFMAVgBOACAA
# UwBlAHIAdgBlAHIwDQYJKoZIhvcNAQEBBQAEggEAYI6Pi3VGf5O5O9QE0nYl1P4r
# 1vfT1x7rcnElGyvW2QKhq87inADRmtDTGu3gmlCtjPMyKb9qHBBUypSOwCSI6Lz1
# sAeAk7NYpfjIYnFfp3+l+nZoqE9WSyUeHQoqomwuaygM7AIGUgGqxRLfpC782Qor
# L4p2sZUg137xc2/Cv9ESWqD0WAYkZbV9nwioSEqjLnjKXfShtSFPd01uf6vgdS3J
# WYq4c/80+GjVd2BuBkiukfzCVGrgYnNzIqDoJEdZzczHlgwfrCdt1pLk24PkyM1u
# Dzr2H2vfgEYAul/qHt7ydacsCyFy0xVWSflsXfsv0mwVyCvgTRkWZBNMj9TNJqGC
# AgswggIHBgkqhkiG9w0BCQYxggH4MIIB9AIBATByMF4xCzAJBgNVBAYTAlVTMR0w
# GwYDVQQKExRTeW1hbnRlYyBDb3Jwb3JhdGlvbjEwMC4GA1UEAxMnU3ltYW50ZWMg
# VGltZSBTdGFtcGluZyBTZXJ2aWNlcyBDQSAtIEcyAhAOz/Q4yP6/NW4E2GqYGxpQ
# MAkGBSsOAwIaBQCgXTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3
# DQEJBTEPFw0xOTA2MjUxNzA3MzFaMCMGCSqGSIb3DQEJBDEWBBQ7j9Bxmgvm8Q8K
# 1vl3g/dksY2XpzANBgkqhkiG9w0BAQEFAASCAQBvQlLnCVsWNi1gEhjibRb24Jts
# rDCuVbbGQHGZvdkEX3nR2WdfHvixqqTm2vtfZo/99Fhd+uObVhEvRnMmulxsGHGd
# ummw9m9g6cWXamCCZa2xvrNA+Zyr1c3XwRajayx3DK+EwHp1Wpp3ADfvT6ZL4eYy
# OzASg//NonoX/K4x/pRDYEwJfc0LsZUEFP1SEM7PahKZ+sOyaE91T1O0q4AGx8Us
# eIMxLsLAIGlkJAZZHjgKwRP+DfLdrSe/EWwT92GyV1odJZJ4Gk/CXY9LEwXpfgl3
# VyqcXAehPc3wIXPzc8LE3rulLibcVDjzESCONjnP91+Isxhyf15wvmkObAwJ
# SIG # End signature block
