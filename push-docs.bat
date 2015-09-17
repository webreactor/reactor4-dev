git clone https://github.com/webreactor/webreactor.github.io.git .docs-tmp
cd .docs-tmp
xcopy /Y /E ..\docs\* .
git add -A
git commit -m "Docs update"
git push
cd ..
