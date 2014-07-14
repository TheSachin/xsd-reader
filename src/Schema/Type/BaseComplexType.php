<?php
namespace Goetas\XML\XSDReader\Schema\Type;

use Goetas\XML\XSDReader\Schema\Attribute\Attribute;
use Goetas\XML\XSDReader\Schema\Attribute\AttributeHolder;
use Goetas\XML\XSDReader\Schema\Inheritance\Extension;
use Goetas\XML\XSDReader\Schema\Inheritance\Restriction;

abstract class BaseComplexType extends Type implements AttributeHolder
{

    /**
     *
     * @var Restriction
     */
    protected $restriction;

    /**
     *
     * @var Extension
     */
    protected $extends;

    protected $attributes = array();

    /**
     *
     * @return \Goetas\XML\XSDReader\Schema\Inheritance\Base
     */
    public function getParent()
    {
        return $this->restriction ?  : $this->extends;
    }

    public function addAttribute(Attribute $attribute)
    {
        $this->attributes[] = $attribute;
    }

    public function getRestriction()
    {
        return $this->restriction;
    }

    public function setRestriction(Restriction $restriction)
    {
        $this->restriction = $restriction;
        return $this;
    }

    public function getExtends()
    {
        return $this->extends;
    }

    public function setExtends(Extension $extends)
    {
        $this->extends = $extends;
        return $this;
    }
    public function getAttributes()
    {
        return $this->attributes;
    }
    private static function navAttributes(Attribute $attr){
        $attrs = array();
        if ($attr instanceof AttributeHolder) {
            foreach ($attr->getAttributes() as $attrExtra) {
                $attrs = array_merge($attrs, self::navAttributes($attrExtra));
            }
        } else {
            $attrs[] = $attr;
        }
        return $attrs;

    }
    public function getAllAttributes()
    {
        $attrs = array();
        foreach ($this->getAttributes() as $attr) {
            foreach (self::navAttributes($attr) as $attrExtra) {
                $attrs[] = $attrExtra;
            }
        }
        return $attrs;
    }
}