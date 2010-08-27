git submodule init
git submodule update

cd vendor/Doctrine2
git submodule init
git submodule update
cp build.properties.dev build.properties
phing
rm _Rf libraries/Doctrine2
cp -R build/orm ../../libraries/Doctrine2
cd ../..

rm -Rf libraries/Zend
cp -R vendor/ZendFramework/library libraries

mkdir libraries/ZendX
rm -Rf libraries/ZendX/Application53 libraries/ZendX/Doctrine2
cp -R vendor/ZendX_Application53/lib/ZendX/Application53 libraries/ZendX
cp -R vendor/ZendX_Doctrine2/lib/ZendX/Doctrine2 libraries/ZendX

chmod -R 777 data