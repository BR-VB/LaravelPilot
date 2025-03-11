import PropTypes from 'prop-types';

const ScopeList = ({ scopes, showDescription = false }) => {
    return (
        <div className="flex-grow flex-1 bg-gray-100 bg-opacity-20 border-gray-100 border-1 shadow-md rounded-md">
            {scopes.map((scope) =>
                scope.tasks?.length > 0 ? (
                    <div key={scope.id} className="p-5 my-5 rounded-md text-left">
                        <h3 className="mb-3 font-bold">{scope.label}</h3>
                        <ul>
                            {scope.tasks.map((task) => (
                                <li key={task.id} className="mb-2">
                                    {task.icon && <span>{task.icon}</span>}{" "}
                                    <span dangerouslySetInnerHTML={{ __html: task.title }}></span>
                                    {showDescription && task.description && (
                                        <span
                                            className="block text-center max-w-[90%] break-words mt-2"
                                            dangerouslySetInnerHTML={{ __html: task.description.replace(/\n/g, '<br/>') }}
                                        ></span>
                                    )}
                                </li>
                            ))}
                        </ul>
                    </div>
                ) : null
            )}
        </div>
    );
};

ScopeList.propTypes = {
    scopes: PropTypes.array.isRequired,
    showDescription: PropTypes.bool.isRequired
};

export default ScopeList;
