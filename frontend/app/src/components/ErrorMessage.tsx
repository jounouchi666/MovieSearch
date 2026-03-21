type Props = {
    messages: string|string[]
}

const ErrorMessage = ({ messages }: Props) => {
    messages = Array.isArray(messages) ? messages : [messages];
    return (
        <div>
            {messages.map(message => 
                <p key={message} className="text-red-500">{message}</p>
            )}
        </div>
    );
};

export default ErrorMessage;