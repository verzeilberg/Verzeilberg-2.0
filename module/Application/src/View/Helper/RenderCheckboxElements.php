<?php

namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Symfony\Component\VarDumper\VarDumper;
use function in_array;
use function str_replace;
use function strtolower;
use function trim;

/**
 * This view helper class displays breadcrumbs.
 */
class RenderCheckboxElements extends AbstractHelper
{

    /**
     * @var array|mixed
     */
    private mixed $element;

    /**
     * @param $element
     * @return void
     */
    public function setElement($element): void
    {
        $this->element = $element;
    }

    /**
     * @return string
     */
    public function render(): string
    {

        $elementName    = $this->element->getAttributes()['name'];
        $formElement    = '<div class="form-group mb-2">';
        $formElement    .= '<label for="formGroupExampleInput">'.$this->element->getLabel().'</label>';
        $formElement    .= '</div>';

        $elementId = 0;
        foreach($this->element->getValueOptions() as $value => $label) {

            $checked = in_array($label['value'], $this->element->getValue())? 'checked':'';

            $formElement    .= '<div class="form-check">';
            $formElement    .= '<input type="checkbox" name="'.$elementName.'[]" id="'. $this->returnForName($this->element->getLabel()) . $elementId . '" '.$checked.' ';
            $formElement    .= 'value="'.$label['value'].'">';
            $formElement    .= '<label for="'. $this->returnForName($label['label']) . $elementId . '" ';
            foreach ($this->element->getLabelAttributes() as $attribute => $attributeValue)
            {
                $formElement    .= $attribute.'="'.$attributeValue.'"';
            }
            $formElement    .= '>';
            $formElement    .= $label['label'];
            $formElement    .= '</label>';
            $formElement    .= '</div>';

            $elementId++;
        }

        return $formElement;
    }

    /**
     * @param string $name
     * @return string
     */
    private function returnForName(string $name): string
    {
        return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
    }
}