<?php
namespace DeepCopyTest\Reflection;

use DeepCopy\Reflection\ReflectionHelper;

/**
 * Test ReflectionHelper
 */
class ReflectionHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testMaintainPropertiesKey()
    {
        $child = new ReflectionHelperTestChild();
        $ref = new \ReflectionClass($child);

        $expectedProps = array(
            'a1',
            'a2',
            'a3',
            'a4',
            'a5',
            'a6',
            'a7',
            'a8',
            'a9',
        );

        $actualProps = ReflectionHelper::getProperties($ref);

        $this->assertSame($expectedProps, array_keys($actualProps));
    }

    /**
     * @dataProvider propertyDataProvider
     *
     * @param string $name
     */
    public function testGetProperty($name)
    {
        $object = new ReflectionHelperTestChild();
        $property = ReflectionHelper::getProperty($object, $name);
        $this->assertInstanceOf('\ReflectionProperty', $property);
        $this->assertSame($name, $property->getName());
    }

    /**
     * @return array
     */
    public function propertyDataProvider()
    {
        return [
            'public property' => ['a4'],
            'private property' => ['a9'],
            'private property of ancestor' => ['a3']
        ];
    }

    /**
     * @expectedException \DeepCopy\Exception\PropertyException
     */
    public function testGetPropertyWhenNotExist()
    {
        $object = new ReflectionHelperTestChild();
        ReflectionHelper::getProperty($object, 'notExistingProperty');
    }
}

class ReflectionHelperTestParent {
    public $a1;
    protected $a2;
    private $a3;

    public $a4;
    protected $a5;
    private $a6;
}

class ReflectionHelperTestChild extends ReflectionHelperTestParent {
    public $a1;
    protected $a2;
    private $a3;

    public $a7;
    protected $a8;
    private $a9;
}
