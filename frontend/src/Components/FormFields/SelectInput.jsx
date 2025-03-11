import PropTypes from 'prop-types';

const SelectInput = ({
    id,
    label = '',
    value = 0,
    onChange,
    options = [],
    required = false,
    disabled = false,
    className = '',
    fieldWidth = 'w-full',
    autofocus = false,
}) => {
    const selectElement = (
        <select
            id={id}
            name={id}
            value={value || ""}
            onChange={onChange}
            required={required}
            disabled={disabled}
            autoFocus={autofocus}
            className={`${fieldWidth} ${className}`}
        >
            {options.map((option, index) => (
                <option key={index} value={option.value}>
                    {option.label}
                </option>
            ))}
        </select>
    );

    return (
        <div className="form-group">
            {label && (
                <label htmlFor={id} className="block text-sm font-medium text-gray-700">
                    {label}
                </label>
            )}
            {selectElement}
        </div>
    );
};

SelectInput.propTypes = {
    id: PropTypes.string.isRequired,
    label: PropTypes.string,
    value: PropTypes.number,
    onChange: PropTypes.func.isRequired,
    options: PropTypes.arrayOf(
        PropTypes.shape({
            value: PropTypes.number,
            label: PropTypes.string.isRequired,
        })
    ),
    required: PropTypes.bool,
    disabled: PropTypes.bool,
    className: PropTypes.string,
    fieldWidth: PropTypes.string,
    autofocus: PropTypes.bool,
};

export default SelectInput;
