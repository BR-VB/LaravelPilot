import PropTypes from 'prop-types';

const PasswordInput = ({
    id,
    label = '',
    value,
    onChange,
    placeholder = '',
    autocomplete = 'current-password',
    required = false,
    disabled = false,
    className = '',
    fieldWidth = 'w-full',
    autofocus = false,
}) => {
    const inputElement = (
        <input
            type="password"
            id={id}
            name={id}
            value={value || ""}
            onChange={onChange}
            placeholder={placeholder}
            autoComplete={autocomplete}
            required={required}
            disabled={disabled}
            autoFocus={autofocus}
            className={`${fieldWidth} ${className}`}
        />
    );

    return (
        <div className="form-group">
            {label && (
                <label htmlFor={id} className="block text-sm font-medium text-gray-700">
                    {label}
                    {inputElement}
                </label>
            )}
            {!label && inputElement}
        </div>
    );
};

PasswordInput.propTypes = {
    id: PropTypes.string.isRequired,
    label: PropTypes.string,
    value: PropTypes.string,
    onChange: PropTypes.func.isRequired,
    placeholder: PropTypes.string,
    autocomplete: PropTypes.string,
    required: PropTypes.bool,
    disabled: PropTypes.bool,
    className: PropTypes.string,
    fieldWidth: PropTypes.string,
    autofocus: PropTypes.bool,
};

export default PasswordInput;
