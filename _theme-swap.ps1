$exts = @('*.php','*.css','*.html','*.js')
$files = Get-ChildItem -Recurse -File -Include $exts
$map = [ordered]@{
'#1a237e'='#111111'; '#0d1757'='#000000'; '#0d47a1'='#000000'; '#3949ab'='#222222'; '#3f51b5'='#222222'; '#5c6bc0'='#333333'; '#667eea'='#222222'; '#764ba2'='#444444';
'%231a237e'='%23111111'; '%230d1757'='%23000000'; '%230d47a1'='%23000000'; '%233949ab'='%23222222'; '%233f51b5'='%23222222'; '%235c6bc0'='%23333333'; '%23667eea'='%23222222'; '%23764ba2'='%23444444';
'#e0e7ff'='#e5e7eb'; '#d7def7'='#e5e7eb'; '#f7f9ff'='#f5f5f5'; '#ecf5fa'='#f3f4f6'; '#aac7dd'='#9ca3af'; '#bed3e3'='#9ca3af'; '#bfd4e0'='#d1d5db'; '#b1c7d4'='#9ca3af';
'#8aaebf'='#6b7280'; '#8aa1ad'='#6b7280'; '#7a9bb0'='#6b7280'; '#6b8fa1'='#6b7280'; '#557d92'='#4b5563'; '#1d5e7a'='#111111'; '#1a3b48'='#111111'; '#1d445b'='#111111';
'#17303d'='#111111'; '#66818f'='#4b5563'; '#b0cbd9'='#9ca3af'
}
$changed = 0
foreach ($f in $files) {
  $old = Get-Content -Raw -Path $f.FullName
  $new = $old
  foreach ($k in $map.Keys) { $new = $new.Replace($k, $map[$k]) }
  if ($new -ne $old) {
    Set-Content -Path $f.FullName -Value $new -NoNewline
    $changed++
  }
}
Write-Host "Updated files: $changed"
