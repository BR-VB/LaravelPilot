import PropTypes from 'prop-types';

const TextareaInput = ({
    id,
    label = '',
    value = '',
    onChange,
    placeholder = '',
    autocomplete = 'off',
    required = false,
    disabled = false,
    className = '',
    fieldWidth = 'w-full',
    autofocus = false,
    rows = 4,
}) => {
    const textAreaElement = (
        <textarea
            id={id}
            name={id}
            value={value || ""}
            onChange={onChange}
            placeholder={placeholder}
            autoComplete={autocomplete}
            required={required}
            disabled={disabled}
            autoFocus={autofocus}
            rows={rows}
            className={`${fieldWidth} ${className}`}
        />
    );

    return (
        <div className="form-group">
            {label && (
                <label htmlFor={id} className="block text-sm font-medium text-gray-700">
                    {label}
                    {textAreaElement}
                </label>
            )}
            {!label && textAreaElement}
        </div>
    );
};

TextareaInput.propTypes = {
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
    rows: PropTypes.number,
};

export default TextareaInput;
