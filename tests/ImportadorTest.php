<?php

use PHPUnit\Framework\TestCase;

class ImportadorTest extends TestCase
{


    public function testDeveRemoverCaracteresDoCpf()
    {

        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);


        //Act
        $result = $abstractImportadorMock->removerCracteresCpf('@@### 124.874.458-68');

        //Assert
        $this->assertEquals('12487445868', $result);
    }

    public function testDeveRemoverCractereseEspacosDaCredencial()
    {

        //Arrange
        /**
         * @deprecated version 10.1
         */
        $abstractImportadorMock = $this->getMockForAbstractClass(Importador::class);


        //Act
        $result = $abstractImportadorMock->removerCracteresCredencial('04EX.9000008-#00 1');



        //Assert
        $this->assertEquals('04EX9000008001' , $result);
    }
}
