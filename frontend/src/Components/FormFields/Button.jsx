import PropTypes from 'prop-types';

const Button = ({
    type,
    label,
    className = '',
}) => {
    return (
        <button
            type={type}
            className={`${className}`}
        >
            {label}
        </button>
    );
};

Button.propTypes = {
    type: PropTypes.string.isRequired,
    label: PropTypes.string.isRequired,
    className: PropTypes.string,
};

export default Button;
