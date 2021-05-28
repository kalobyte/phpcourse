<?php


class Validator
{
    private $errors = [];
    private $isValidated = false;
    private $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate()
    {
        foreach ($this->rules as $fieldName => $ruleNames)
        {
            // fieldName - (string) название полей в форме из конфига правил
            // ruleNames - (array) название правила из конфига правил + значения к ним
            // ruleValue - значение правила из конфига правил
            // formValue - значение из поля в форме с привязкой к соответствующему имени поля в fieldNames
            foreach ($ruleNames as $ruleName => $ruleValue)
            {
                $formValue = $_POST[$fieldName];

                if ($ruleName == "required" && empty($formValue))
                {
                    $this->setErrors("{$fieldName} is empty");
                }
                elseif (!empty($formValue))
                {
                    switch ($ruleName)
                    {
                        case "email":
                            if (!filter_var($formValue, FILTER_VALIDATE_EMAIL)) {
                                $this->setErrors("{$formValue} not email");
                            }
                            break;

                        case "match":
                            if ($formValue !== $_POST[$ruleValue]) {
                                $this->setErrors("password doesn't match with password again");
                            }
                            break;

                        case "min":
                            if (strlen($formValue) < $ruleValue) {
                                $this->setErrors("{$formValue} is less than {$ruleValue}");
                            }
                            break;

                        case "max":
                            if (strlen($formValue) > $ruleValue) {
                                $this->setErrors("{$formValue} is greater than {$ruleValue}");
                            }
                            break;
                    }
                }

            }
        }
        if(empty($this->errors)) $this->isValidated = true;
    }


    /**
     * @param string $error
     */
    private function setErrors(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isValidated(): bool
    {
        return $this->isValidated;
    }
}