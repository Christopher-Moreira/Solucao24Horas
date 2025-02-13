<?php
namespace Adianti\Widget\Form;

use Adianti\Widget\Form\AdiantiWidgetInterface;
use Adianti\Core\AdiantiCoreTranslator;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Base\TScript;
use Adianti\Widget\Form\TField;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Util\TImage;
use Adianti\Control\TAction;

use Exception;

/**
 * Password Widget
 *
 * @version    7.5
 * @package    widget
 * @subpackage form
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TPassword extends TField implements AdiantiWidgetInterface
{
    private $exitAction;
    private $exitFunction;
    protected $formName;
    protected $innerIcon;
    protected $id;
    private $toggleVisibility;
    private $strongPassword;
    private $strongPasswordOptions;
    private $defaultStrongPasswordOptions;
    private $passwordLabel;

    /**
     * Class Constructor
     * @param string $name Name of the widget
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $this->id = 'tpassword_'.mt_rand(1000000000, 1999999999);
        $this->toggleVisibility = TRUE;
        $this->strongPassword = false;

        $this->defaultStrongPasswordOptions = [
            'minLength' => [
                'value' => 8,
                'message' => '8 '.AdiantiCoreTranslator::translate('characters')
            ],
            'requireNumbers' => [
                'value' => true,
                'message' => AdiantiCoreTranslator::translate('At least 1 number')
            ],
            'requireLowercase' => [
                'value' => true,
                'message' => AdiantiCoreTranslator::translate('At least 1 lowercase letter')
            ],
            'requireUppercase' => [
                'value' => true,
                'message' => AdiantiCoreTranslator::translate('At least 1 uppercase letter')
            ],
            'requireSpecialChar' => [
                'value' => true,
                'message' => AdiantiCoreTranslator::translate('At least 1 special character')
            ]
        ];
        
        $this->strongPasswordOptions = $this->defaultStrongPasswordOptions;
    }
    
    /**
     * Enable or disable password visibility toggle
     * @param bool $toggleVisibility
     */
    public function enableToggleVisibility($toggleVisibility = TRUE)
    {
        $this->toggleVisibility = $toggleVisibility;
    }

    /**
     * Define the action to be executed when the user leaves the form field
     * @param TAction $action TAction object
     */
    public function setExitAction(TAction $action)
    {
        if ($action->isStatic())
        {
            $this->exitAction = $action;
        }
        else
        {
            $string_action = $action->toString();
            throw new Exception(AdiantiCoreTranslator::translate('Action (^1) must be static to be used in ^2', $string_action, __METHOD__));
        }
    }
    
    /**
     * Define max length
     * @param int $length Max length
     */
    public function setMaxLength($length)
    {
        if ($length > 0)
        {
            $this->tag->{'maxlength'} = $length;
        }
    }
    
    /**
     * Define the Inner icon
     * @param TImage $image
     * @param string $side
     */
    public function setInnerIcon(TImage $image, $side = 'right')
    {
        $this->innerIcon = $image;
        $this->innerIcon->{'class'} .= ' input-inner-icon ' . $side;
        
        if ($side == 'left')
        {
            $this->setProperty('style', "padding-left:23px", false); //aggregate style info
        }
    }
    
    /**
     * Define the javascript function to be executed when the user leaves the form field
     * @param string $function Javascript function
     */
    public function setExitFunction($function)
    {
        $this->exitFunction = $function;
    }
    
    /**
     * Disable auto complete
     */
    public function disableAutoComplete()
    {
        $this->tag->{'autocomplete'} = 'new-password';
    }

    /**
     * Enables strong password validation with customizable options.
     *
     * @param string $label The label of the password field to be used in error messages
     * @param array $options An associative array with validation options.
     *                       Each key in the array represents a validation rule,
     *                       and its value is another array with 'value' and 'message'.
     *
     * Available options:
     * - minLength: ['value' => int, 'message' => string]
     * - requireNumbers: ['value' => bool, 'message' => string]
     * - requireLowercase: ['value' => bool, 'message' => string]
     * - requireUppercase: ['value' => bool, 'message' => string]
     * - requireSpecialChar: ['value' => bool, 'message' => string]
     *
     * @example
     * $password->enableStrongPasswordValidation('Password', [
     *     'minLength' => ['value' => 10, 'message' => '{label} must have at least {value} characters'],
     *     'requireNumbers' => ['value' => false],
     *     'requireSpecialChar' => ['message' => '{label} must include at least one special character']
     * ]);
     *
     * @return void
     */
    public function enableStrongPasswordValidation($label, array $options = [])
    {
        $this->strongPassword = true;
        $this->passwordLabel = $label;
        
        foreach ($options as $key => $option) {
            if (isset($this->defaultStrongPasswordOptions[$key])) {
                $this->strongPasswordOptions[$key] = array_merge(
                    $this->defaultStrongPasswordOptions[$key],
                    $option
                );
            }
        }
    }

    /**
     * Validates the password against the defined strong password options.
     *
     * @param string $value The password to validate
     * @return bool Returns true if the password is valid, false otherwise
     * @throws Exception if the password does not meet the defined criteria
     */
    public function validate()
    {
        $value = $this->getValue();
        if ($this->strongPassword && $value) 
        {
            $errors = [];

            // Check minimum length
            if (!empty($this->strongPasswordOptions['minLength'])) {
                $minLength = $this->strongPasswordOptions['minLength']['value'];
                if (strlen($value) < $minLength) {
                    $errors[] = ' - '.str_replace('{value}', $minLength, $this->strongPasswordOptions['minLength']['message']);
                }
            }

            // Check for numbers
            if (!empty($this->strongPasswordOptions['requireNumbers']) && $this->strongPasswordOptions['requireNumbers']['value']) {
                if (!preg_match('@[0-9]@', $value)) {
                    $errors[] = ' - '.$this->strongPasswordOptions['requireNumbers']['message'];
                }
            }

            // Check for lowercase letters
            if (!empty($this->strongPasswordOptions['requireLowercase']) && $this->strongPasswordOptions['requireLowercase']['value']) {
                if (!preg_match('@[a-z]@', $value)) {
                    $errors[] = ' - '.$this->strongPasswordOptions['requireLowercase']['message'];
                }
            }

            // Check for uppercase letters
            if (!empty($this->strongPasswordOptions['requireUppercase']) && $this->strongPasswordOptions['requireUppercase']['value']) {
                if (!preg_match('@[A-Z]@', $value)) {
                    $errors[] = ' - '.$this->strongPasswordOptions['requireUppercase']['message'];
                }
            }

            // Check for special characters
            if (!empty($this->strongPasswordOptions['requireSpecialChar']) && $this->strongPasswordOptions['requireSpecialChar']['value']) {
                if (!preg_match('@[^\w]@', $value)) {
                    $errors[] = ' - '.$this->strongPasswordOptions['requireSpecialChar']['message'];
                }
            }
            

            if (!empty($errors)) {

                $errorMessage = AdiantiCoreTranslator::translate('The field ^1 must have', $this->passwordLabel);

                throw new Exception($errorMessage.': <br>'.implode('<br>', $errors));
            }
        }
        
        parent::validate();
    }
    
    /**
     * Show the widget at the screen
     */
    public function show()
    {
        // define the tag properties
        $this->tag->name  = $this->name;    // tag name
        $this->tag->value = $this->value;   // tag value
        $this->tag->type  = 'password';     // input type
        
        if (!empty($this->size))
        {
            if (strstr((string) $this->size, '%') !== FALSE)
            {
                $this->setProperty('style', "width:{$this->size};", FALSE); //aggregate style info
            }
            else
            {
                $this->setProperty('style', "width:{$this->size}px;", FALSE); //aggregate style info
            }
        }
        
        // verify if the field is not editable
        if (parent::getEditable())
        {
            if (isset($this->exitAction))
            {
                if (!TForm::getFormByName($this->formName) instanceof TForm)
                {
                    throw new Exception(AdiantiCoreTranslator::translate('You must pass the ^1 (^2) as a parameter to ^3', __CLASS__, $this->name, 'TForm::setFields()') );
                }
                
                $string_action = $this->exitAction->serialize(FALSE);
                $this->setProperty('onBlur', "__adianti_post_lookup('{$this->formName}', '{$string_action}', this, 'callback')");
            }
            
            if (isset($this->exitFunction))
            {
                $this->setProperty('onBlur', $this->exitFunction, FALSE );
            }
        }
        else
        {
            // make the field read-only
            $this->tag->readonly = "1";
            $this->tag->{'class'} .= ' tfield_disabled'; // CSS
            $this->tag->{'tabindex'} = '-1';
        }
        
        if ($this->toggleVisibility)
        {
            $div    = new TElement('div');
            $button = new TElement('button');
            $icon   = new TElement('i');

            $div->{'id'} = $this->id;

            $icon->{'class'} = 'fa fa-eye-slash';
            $div->{'class'} = 'tpassword';

            $button->{'type'} = 'button';

            $button->add($icon);
            $div->add($this->innerIcon);
            $div->add($this->tag);
            $div->add($button);

            $div->show();

            TScript::create("tpassword_start('{$this->id}');");
        }
        else if (!empty($this->innerIcon))
        {
            $icon_wrapper = new TElement('div');
            $icon_wrapper->add($this->tag);
            $icon_wrapper->add($this->innerIcon);
            $icon_wrapper->show();
        }
        else
        {
            // shows the tag
            $this->tag->show();
        }

        if($this->strongPassword)
        {
            $this->strongPasswordOptions['popoverTitle'] = AdiantiCoreTranslator::translate('The field ^1 must have', $this->passwordLabel).':';
            $options = json_encode($this->strongPasswordOptions);
            TScript::create("tpassword_enable_strong_validation('{$this->id}', $options)");
        }
    }
}