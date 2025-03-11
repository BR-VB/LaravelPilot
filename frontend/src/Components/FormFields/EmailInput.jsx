import PropTypes from 'prop-types';

const EmailInput = ({
    id,
    label = '',
    value,
    onChange,
    placeholder = '',
    autocomplete = 'email',
    required = false,
    disabled = false,
    className = '',
    fieldWidth = 'w-full',
    autofocus = false,
}) => {
    const inputElement = (
        <input
            type="email"
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

EmailInput.propTypes = {
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

export default EmailInput;
